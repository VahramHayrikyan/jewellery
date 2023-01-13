<?php

namespace App\Http\Requests\Admin\AttribiteValue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveAVProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute_value_id' => ['required', 'integer', 'exists:attribute_values,id'],
            'product_id' => ['required', 'integer', 'exists:products,id', Rule::unique('attribute_value_product')->where(function ($q) {
                return $q->where('attribute_value_id', request()->attribute_value_id);
            })],
            'price' => ['nullable', 'numeric'],
        ];
    }
}
