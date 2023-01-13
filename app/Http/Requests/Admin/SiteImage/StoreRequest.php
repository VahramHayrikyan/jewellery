<?php

namespace App\Http\Requests\Admin\SiteImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:2048'],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();
        $validated['type'] = 'slider';

        return $validated;
    }
}
