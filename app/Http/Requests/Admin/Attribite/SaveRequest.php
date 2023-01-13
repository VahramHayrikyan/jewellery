<?php

namespace App\Http\Requests\Admin\Attribite;

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
        $id = $this->attribute ? $this->attribute->id : 'NULL';

        return [
            'name' => ['required', 'string', 'max:255', 'unique:attributes,name,' . $id]
        ];
    }
}
