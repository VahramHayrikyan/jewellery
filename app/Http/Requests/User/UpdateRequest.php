<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'   => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'old_password' => ['required_with:new_password,password_confirmation'],
            'password' => ['required_with:password,password_confirmation', 'confirmed', 'string', 'min:6'],
            'password_confirmation' => ['required_with:new_password,password'],
        ];
    }
}
