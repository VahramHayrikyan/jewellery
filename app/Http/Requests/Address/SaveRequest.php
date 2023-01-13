<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        $authorized = true;
        if ($this->address) $authorized = $this->address->user_id === auth()->user()->id;

        return $authorized;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:billing,shipping'],
            'postal_code' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'apartment' => ['required', 'string', 'max:255'],
        ];
    }
}
