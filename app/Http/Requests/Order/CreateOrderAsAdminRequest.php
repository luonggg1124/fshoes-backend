<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateOrderAsAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'errors' => $errors->messages()
        ], 400);
        throw new HttpResponseException($response);
    }
    public function rules(): array
    {
        return [
            "total_amount" => "required|numeric|max:2000000000",
            "payment_method" => "required|string|min:0|max:255",
            "payment_status" => "required|string|min:0|max:255",
            'receiver_email' => 'nullable|email',
            "shipping_method" => "nullable|string|max:255",
            "shipping_cost" => "required|numeric|min:0",
            "amount_collected" => "required|numeric|min:0|max:2000000000",
            "receiver_full_name" => "nullable|string|max:255",
            "phone" => "nullable|string|max:20",
            "city" => "nullable|string|max:255",
            "country" => "nullable|string|max:255",
            "address" => "nullable|string|max:1024",
            "status" => "required",
            "user_id" => "nullable|numeric",
            "order_details" => "required|array",
            "order_details.*.price" => "required|numeric",
            "order_details.*.quantity" => "required|numeric",
            "order_details.*.total_amount" => "required|numeric",
        ];
    }
    public function messages()
    {
        return [
            'receiver_email.required' => __('messages.create_order_request.receiver_email.required'),
            'receiver_email.email' => __('messages.create_order_request.receiver_email.email'),
            'total_amount.required' => __('messages.create_order_request.total_amount.required'),
            'total_amount.numeric' => __('messages.create_order_request.total_amount.numeric'),
            'total_amount.max' => __('messages.create_order_request.total_amount.max'),
            'payment_method.required' => __('messages.create_order_request.payment_method.required'),
            'payment_method.string' => __('messages.create_order_request.payment_method.string'),
            'payment_method.min' => __('messages.create_order_request.payment_method.min'),
            'payment_method.max' => __('messages.create_order_request.payment_method.max'),
            'payment_status.required' => __('messages.create_order_request.payment_status.required'),
            'payment_status.string' => __('messages.create_order_request.payment_status.string'),
            'payment_status.min' => __('messages.create_order_request.payment_status.min'),
            'payment_status.max' => __('messages.create_order_request.payment_status.max'),
            'shipping_method.string' => __('messages.create_order_request.shipping_method.string'),
            'shipping_method.max' => __('messages.create_order_request.shipping_method.max'),
            'shipping_cost.required' => __('messages.create_order_request.shipping_cost.required'),
            'shipping_cost.numeric' => __('messages.create_order_request.shipping_cost.numeric'),
            'shipping_cost.min' => __('messages.create_order_request.shipping_cost.min'),
            'amount_collected.required' => __('messages.create_order_request.amount_collected.required'),
            'amount_collected.numeric' => __('messages.create_order_request.amount_collected.required'),
            'amount_collected.min' => __('messages.create_order_request.amount_collected.min'),
            'amount_collected.max' =>  __('messages.create_order_request.amount_collected.max'),
            'receiver_full_name.string' => __('messages.create_order_request.receiver_full_name.string'),
            'receiver_full_name.max' => __('messages.create_order_request.receiver_full_name.max'),
            'phone.string' => __('messages.create_order_request.phone.string'),
            'phone.max' => __('messages.create_order_request.phone.max'),
            'city.string' => __('messages.create_order_request.city.string'),
            'city.max' => __('messages.create_order_request.city.max'),
            'country.string' => __('messages.create_order_request.country.required'),
            'country.max' => __('messages.create_order_request.country.max'),
            'address.string' => __('messages.create_order_request.address.string'),
            'address.max' => __('messages.create_order_request.address.max'),
            "status.required" => __('messages.create_order_request.status.required'),
            "user_id.numeric" => __('messages.create_order_request.user_id.numeric'),
            "order_details.required" => __('messages.create_order_request.order_details.required'),
            "order_details.*.price.required" => __('messages.create_order_request.order_details.*.price.required'),
            "order_details.*.price.numeric" => __('messages.create_order_request.order_details.*.price.numeric'),
            "order_details.*.quantity.required" => __('messages.create_order_request.order_details.*.price.required'),
            "order_details.*.quantity.numeric" => __('messages.create_order_request.order_details.*.price.numeric'),
            "order_details.*.total_amount.required" => __('messages.create_order_request.order_details.*.price.required'),
            "order_details.*.total_amount.numeric" => __('messages.create_order_request.order_details.*.price.numeric'),
        ];
    }
}
