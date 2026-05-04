<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['available', 'sold', 'lost', 'damaged', 'melted', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
