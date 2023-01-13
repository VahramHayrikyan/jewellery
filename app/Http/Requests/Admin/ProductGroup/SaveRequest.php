<?php

namespace App\Http\Requests\Admin\ProductGroup;

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
            'product_id' => ['required', 'integer', 'exists:products,id,deleted_at,NULL', Rule::unique('product_groups', 'product_id')->where(function ($q) {
                if (request()->type === 'new') {
                    return $q->where('type', 'new');
                } else{
                    return  $q->where('type', 'best_seller');
                }
            })],
            'type' => ['required', 'string', 'in:best_seller,new'],
        ];
    }
}
