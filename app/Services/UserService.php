<?php

namespace App\Services;

use App\Models\User;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Exception;

Class UserService extends BaseService
{
    public function update(array $data, User $user)
    {
        if (!Hash::check($data['old_password'], $user->password)) throw new Exception('Wrong old password.');
        else {
            $data['password'] = Hash::make($data['password']);
            unset($data['old_password']);
            unset($data['password_confirmation']);
            $user->update($data);
        }
    }
}
