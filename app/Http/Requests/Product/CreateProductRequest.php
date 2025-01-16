<?php

namespace App\Http\Requests\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required|numeric|min:0|max:1000000000',
            'description' => 'nullable|min:0|max:1024',
            'short_description' => 'nullable|min:0|max:1024',
            'image_url' => 'required|string',
            'stock_qty' => 'nullable|numeric|min:0|max:1000000',
            'status' => 'nullable|boolean',
            'images' => 'nullable|array',
            'categories' => 'nullable|array',
            'is_variant' => 'nullable|boolean',
            'variations' => 'nullable|array',
            'variations.*.price' => 'required|numeric|min:0|max:1000000000',
            'variations.*.stock_qty' => 'required|numeric|min:0|max:10000000',
            'variations.*.status' => 'nullable|boolean',
            'variations.*.values' => 'required|array',
            'variations.*.sku' => "nullable|string|min:0|max:255",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'errors' => $errors->messages()
        ], 400);
        throw new HttpResponseException($response);
    }
    public function messages()
    {
        return [
            'name.required' => __('messages.create_product_request.name.required'),
            'name.unique' => __('messages.create_product_request.name.unique'),
            'name.string' => __('messages.create_product_request.name.string'),
            'name.max' => __('messages.create_product_request.name.max'),
            'description.nullable' => __('messages.create_product_request.description.nullable'),
            'price.required' => __('messages.create_product_request.price.required'),
            'price.numeric' => __('messages.create_product_request.price.numeric'),
            'price.min' => __('messages.create_product_request.price.min'),
            'price.max' => __('messages.create_product_request.price.max'),
            'short_description.nullable' => __('messages.create_product_request.short_description.nullable'),
            'stock_qty.required' => __('messages.create_product_request.stock_qty.required'),
            'stock_qty.numeric' => __('messages.create_product_request.stock_qty.numeric'),
            'stock_qty.min' => __('messages.create_product_request.stock_qty.min'),
            'stock_qty.max' => __('messages.create_product_request.stock_qty.max'),
            'variations.*.price.min' => __('messages.create_product_request.variations.*.price.min'),
            'variations.*.price.max' => __('messages.create_product_request.variations.*.price.max'),
            'variations.*.stock_qty.min' => __('messages.create_product_request.variations.*.stock_qty.min'),
            'variations.*.stock_qty.max' => __('messages.create_product_request.variations.*.stock_qty.max'),
            'image_url.required' => __('messages.create_product_request.image_url.required'),
            'image_url.string' => __('messages.create_product_request.image_url.string'),
            'images.nullable' => __('messages.create_product_request.images.nullable'),
            'images.array' => __('messages.create_product_request.images.array'),
            'categories.nullable' => __('messages.create_product_request.categories.nullable'),
            'categories.array' => __('messages.create_product_request.categories.array'),

        ];
    }
}
