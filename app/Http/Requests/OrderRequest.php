<?php

namespace App\Http\Requests;

use App\Enums\Departments;
use App\Enums\WarehousePriority;
use App\Models\OrderItems;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class OrderRequest extends FormRequest
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
            'customerId' => ['required', 'exists:customers,id'],
            'orderItems' => ['array'],
            'orderItems.*.orderItemId' => ['nullable', 'exists:order_items,id'],
            'orderItems.*.productId' => ['sometimes', 'exists:products,id'],
            'orderItems.*.product.sku' => ['required', Rule::exists('products', 'sku')],
            'orderItems.*.quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable'],
            'priority' => ['nullable', new Enum(WarehousePriority::class)],
            'isAnyProductOutOfStock' => ['boolean', 'required'],
        ];

    }

    function messages()
    {
        return [
            'customerId.required' => 'Customer field is required',
            'customerId.exists' => 'The provided customer is invalid',
            'orderItems.array' => 'Please add at least one product',
            'orderItems.*.orderItemId.exists' => 'The provided order item is invalid',
            'orderItems.*.productId.exists' => 'The provided product is invalid',
            'orderItems.*.product.sku.required' => 'Please add at least one product',
            'orderItems.*.product.sku.exists' => 'The provided sku is invalid',
            'orderItems.*.quantity.required' => 'Quantity field is required',
            'orderItems.*.quantity.min' => 'The minimum quantity is 1',
        ];
    }


}