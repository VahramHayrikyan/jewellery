<?php

namespace App\Http\Requests\Admin\Product;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Save extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = request()->route()->getName() === 'products.update';
        $id = null;

        if ($isUpdate) {
            $id = intval($this->product->id);
        }

        return [
            'id' => ['sometimes', 'required', 'integer', 'exists:products,id'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['required', 'integer', 'exists:categories,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'code' => ['required', 'string', 'max:50', 'unique:products,code,'.$id.',id,deleted_at,NULL'],
            'price' => ['required', 'numeric'],
            'discount' => ['nullable', 'numeric', 'max:100'],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();
        unset($validated['category_ids']);

        return $validated;
    }
}
