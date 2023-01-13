<?php

namespace App\Http\Requests\CartProduct;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'sometimes', 'integer', 'exists:products,id'],
            'attribute_value_ids' => ['nullable', 'array'],
            'attribute_value_ids.*' => ['required', 'integer', 'exists:attribute_values,id'],
            'quantity' => ['required', 'integer'],
            'comment' => ['nullable', 'string', 'max:20000'],
        ];
    }
}
