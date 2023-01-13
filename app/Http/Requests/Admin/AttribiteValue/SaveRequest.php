<?php

namespace App\Http\Requests\Admin\AttribiteValue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute_id' => ['required', 'integer', 'exists:attributes,id'],
            'name' => ['required', 'string', Rule::unique('attribute_values')->where(function ($q) {
                return $q->where('attribute_id', request()->attribute_id);
            })],
        ];
    }
}
