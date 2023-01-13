<?php

namespace App\Http\Requests\Auth;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users',
//            'email' => ['required', 'email', 'unique:users,email,'.$id.',id,deleted_at,NULL'],
            'password' => 'required|confirmed'
        ];
    }
}
