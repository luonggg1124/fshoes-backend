<?php

namespace App\Services\Voucher;

use Mockery\Exception;
use App\Http\Resources\VoucherResource;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Voucher\VouchersRepositoryInterface;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class VoucherService implements VoucherServiceInterface
{

    public function __construct(protected VouchersRepositoryInterface $vouchersRepository)
    {
    }


    function getAll(array $params)
    {
        $voucher = $this->vouchersRepository->query()->withTrashed()->get();
        return VoucherResource::collection(
            $voucher
        );
    }

    function findById(int|string $id)
    {
        $voucher = $this->vouchersRepository->query()->withTrashed()->find($id);
        if ($voucher) return response()->json(VoucherResource::make($voucher) , 200);
        else return response()->json(["message"=>__('messages.error-not-found')] , 404);

    }

    function findByCode(int|string $code)
    {
        $voucher = $this->vouchersRepository->query()->where('code', $code)->withTrashed()->first();
        if(!$voucher) throw new ModelNotFoundException(__('messages.voucher.invalid-voucher'));
        if($voucher->date_start > Carbon::now()){
            throw new UnprocessableEntityHttpException(__('messages.voucher.invalid-voucher'));
        } else if($voucher->date_end < Carbon::now()){
            throw new UnprocessableEntityHttpException(__('messages.voucher.voucher-expired'));
        }
        if($voucher->quantity === 0) throw new UnprocessableEntityHttpException(__('messages.voucher.number-expired')); 
        $vouchersUsed = request()->user()->voucherUsed()->get()->pluck('id')->toArray();
        $used = in_array($voucher->id,$vouchersUsed);    
        if($used){ throw new UnprocessableEntityHttpException(__('messages.voucher.used'));
        }
        return VoucherResource::make($voucher);
    }

    function create(array $data, array $option = [])
    {
        try {
            $voucher = $this->vouchersRepository->create($data);
            return response()->json(VoucherResource::make($voucher) , 201);

        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                return response()->json(["message" => __('messages.voucher.already-exists')], 400);
            }
            return response()->json(["message" => __('messages.voucher.cant-create')], 500);
        }
        catch (Exception $exception) {
            return response()->json(["message" => __('messages.voucher.cant-create')], 500);
        }
    }

    function update(int|string $id, array $data, array $option = [])
    {
       try {
        $voucher = $this->vouchersRepository->update($id, $data);

        return response()->json(["message"=> __("messages.update-success"),"voucher"=>VoucherResource::make($voucher)], 200);
    } catch (ModelNotFoundException $exception) {
        return response()->json(["message" => __("messages.error-not-found")], 404);
    } catch (QueryException $exception) {
        if ($exception->getCode() == 23000) {
            return response()->json([
                "message" => __("messages.voucher.error-update"),
                "error" => $exception->getMessage(),
            ], 400);
        }

        return response()->json([
            "message" => __("messages.voucher.error-update"),
            "error" => $exception->getMessage(),
        ], 400);
    } catch (Exception $exception) {
        return response()->json(["message" => __("messages.error-anunexpected")], 500);
    }
    }

    function delete(int|string $id)
    {
        $voucher = $this->vouchersRepository->query()->find($id);
        if ($voucher) {
            $voucher->delete();
            return response()->json(["message" => __("messages.voucher.error-soft-deleted")] , 200);
        } else return response()->json(["message" => __("messages.voucher.voucher-not-found")] , 404);

    }

    function restore(int|string $id)
    {
        $voucher = $this->vouchersRepository->query()->withTrashed()->find($id);
        if ($voucher) {
            $voucher->restore();
            return response()->json(["message" => __("messages.voucher.error-restore")] , 200);
        } else return response()->json(["message" => __("messages.voucher.voucher-not-found")] , 404);

    }

    function forceDelete(int|string $id)
    {
        $voucher = $this->vouchersRepository->query()->withTrashed()->find($id);
        if ($voucher) {
            $voucher->forceDelete();
            return response()->json(["message" => __("messages.voucher.error-force-deleted")] , 200);
        } else return response()->json(["message" => __("messages.voucher.voucher-not-found")] , 404);

    }

    public function myVoucher(){
        $user = request()->user();
        $vouchers = $this->vouchersRepository->query()
        ->where('date_start','<=', Carbon::now())
        ->where('date_end', '<=', Carbon::now())->whereDoesntHave('users',function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return VoucherResource::collection($vouchers);
    }
}
