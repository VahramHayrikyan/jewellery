<?php

namespace App\Http\Requests\Admin\Group;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = request()->route()->getName() === 'groups.update';
        $id = null;

        if ($isUpdate) {
            $id = intval($this->group->id);
        }

        return [
            'name' => ['required', 'string', 'max:255', 'unique:groups,name,'.$id],
            'discount' => ['required', 'numeric']
        ];
    }
}
