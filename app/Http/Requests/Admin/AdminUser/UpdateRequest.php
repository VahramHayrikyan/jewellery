<?php

namespace App\Http\Requests\Admin\AdminUser;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return auth()->user()->role_id === Admin::ROLES['super_admin']
            && auth()->user()->id !== $this->admin_user->id;
    }

    public function rules(): array
    {
        return [
            'role_id' => ['required', 'integer'],
        ];
    }
}
