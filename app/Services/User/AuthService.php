<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;
use App\Http\Traits\CanLoadRelationships;
use App\Jobs\SendAuthCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\UnauthorizedException;
use PHPUnit\Event\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class AuthService extends UserService
{
    use CanLoadRelationships;
    public function checkEmail(string $email)
    {
        $user = $this->userRepository->findByColumnOrEmail($email);
        if (!$user) return false;
        return true;
    }
    public function register(array $data, array $options = ['profile' => []])
    {
        $credential = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        $code = Cache::tags(['verifyEmailCode'])->get('verify_email_code-email=' . $data['email']);
        if (empty($data['verify_code']) || $data['verify_code'] != $code) {
            throw new InvalidArgumentException(__('messages.user.error-invalid'));
        }
        $user = DB::transaction(function () use ($data, $options) {
            if ($this->userRepository->query()->where('email', $data['email'])->exists())
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => __('messages.user.error-email')
                ]);
            $data['status'] = 'active';
            $data['password'] = Hash::make($data['password']);
            $data['nickname'] = $this->createNickname($data['name']);
            $data['group_id'] = 3;
            $user = $this->userRepository->create($data);
            if (!$user)
                throw new \Exception(__('messages.user.error-register'));
            $this->createProfile($user->id, $options['profile']);
            return $user;
        }, 3);
        if ($user)
            return $this->login($credential);
        else throw new Exception(__('messages.error-internal-server'));
    }
    public function login(array $credentials = [
        'email' => '',
        'password' => '',
    ])
    {
        $user = $this->userRepository->findByColumnOrEmail($credentials['email']);
       
        if (!$user) throw new ModelNotFoundException(__('messages.error-not-found'));
        $count = Cache::tags(['auth'])->get('password_wrong_limit?email=' . $credentials['email']);
        if ($count == 5) {
            throw new TooManyRequestsHttpException(5 * 60, __('messages.user.error-password'));
        }
        if (!Hash::check($credentials['password'], $user->password)) {

            Cache::tags(['auth'])->put('password_wrong_limit?email=' . $credentials['email'], $count ? $count + 1 : 1, 5 * 60);
            throw new InvalidArgumentException(__('messages.user.error-wrong-password'));
        };
        if($user->status =='banned') {
            throw new UnauthorizedException(__('messages.auth.banned'));
        }
        $token = auth()->login($user);
        $refresh_token = auth()->claims([
            'exp' => now()->addDays(30)->timestamp,
        ])->attempt($credentials);
        $user->load('profile');
        return [
            'access_token' => $token,
            'refresh_token' => $refresh_token,
            'user' => new UserResource($user)
        ];
    }
    public function getCode(string $email)
    {

        $code = random_int(1234567, 9876543);
        Cache::tags(['verifyEmailCode'])->put('verify_email_code-email=' . $email, $code, 5 * 60);
        SendAuthCode::dispatch(code: $code, email: $email);
        return $code;
    }
    public function me()
    {
        $auth = auth('api')->user();
        if($auth){
            $user = $this->userRepository->find($auth->id);
            if(!$user) throw new ModelNotFoundException(__('messages.user.error-account'));
            return new UserResource(
                $this->loadRelationships($user)
            );
        }else {
            throw new UnauthorizedException(__('messages.user.error-login'));
        }
       
    }
    public function changePassword($currenPassword, $newPassword)
    {
        $user = auth()->user();
        $isValid = Hash::check($currenPassword, $user->password);
        if (!$isValid) throw new InvalidArgumentException(__('messages.user.error-current-password'));
        $user->password = Hash::make($newPassword);
        $user->save();
        return true;
    }
    public function sendCodeForgotPassword(string $email)
    {
        $user = $this->userRepository->findByColumnOrEmail($email);
        if (!$user) throw new ModelNotFoundException(__('messages.user.error-can-not-email'));

        $code = $this->getCode($email);
        return $code;
    }
    public function resetPassword($verifyCode, string $email, string $password)
    {
        $user = $this->userRepository->findByColumnOrEmail($email);
        if (!$user) throw new ModelNotFoundException(__('messages.user.error-can-not-email'));
        $code = Cache::tags(['verifyEmailCode'])->get('verify_email_code-email=' . $email);
        if ($code != $verifyCode) {
            throw new InvalidArgumentException(__('messages.user.error-wrong-verification'));
        }
        $user->password = Hash::make($password);
        $user->save();
        Cache::tags(['verifyEmailCode'])->forget('verify_email_code-email=' . $email);
        return true;
    }
}
