<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseTransactionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller_id' => ['nullable', 'exists:sellers,id'],
            'seller.name' => ['required_without:seller_id', 'nullable', 'string', 'max:150'],
            'seller.nik' => ['nullable', 'string', 'max:30'],
            'seller.phone' => ['nullable', 'string', 'max:30'],
            'seller.address' => ['nullable', 'string'],
            'seller.notes' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
            'deduction_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', Rule::in(['cash', 'transfer', 'qris', 'debit', 'other'])],
            'status' => ['required', Rule::in(['draft', 'completed'])],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string', 'max:150'],
            'items.*.item_type' => ['nullable', 'string', 'max:100'],
            'items.*.gold_carat' => ['nullable', 'numeric', 'min:0'],
            'items.*.weight_gram' => ['required', 'numeric', 'gt:0'],
            'items.*.price_per_gram' => ['required', 'numeric', 'min:0'],
            'items.*.deduction_amount' => ['nullable', 'numeric', 'min:0'],
            'items.*.condition' => ['nullable', 'string', 'max:100'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.product_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
