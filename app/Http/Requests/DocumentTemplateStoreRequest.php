<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentTemplateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:100', Rule::unique('document_templates', 'code')->ignore($this->route('document_template'))],
            'document_type' => ['required', Rule::in(['purchase_invoice', 'purchase_agreement', 'goods_receipt', 'sales_invoice'])],
            'html_content' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
