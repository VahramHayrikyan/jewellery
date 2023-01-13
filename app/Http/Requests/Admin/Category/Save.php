<?php

namespace App\Http\Requests\Admin\Category;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
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
        $isUpdate = request()->route()->getName() === 'categories.update';
        $id = null;

        if ($isUpdate) {
            $id = intval($this->category->id);
        }

        return [
            'id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'slug' => ['required', 'string', 'max:50', 'unique:categories,slug,'.$id.',id,deleted_at,NULL'],
        ];
    }
}
