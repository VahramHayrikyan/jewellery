<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin)
    {
//        return false;
    }

    public function view($user, User $model)
    {
        return true;
    }

    public function create(User $user)
    {
        //
    }

    public function update($admin, User $model)
    {
        return $admin->role_id == Admin::ROLES['super_admin']
            || auth()->user()->id === $model->id;
    }

    public function delete(Admin $admin, User $model)
    {
        return $admin->role_id == Admin::ROLES['super_admin'];
    }

    public function restore(User $user, User $model)
    {
        //
    }

    public function forceDelete(User $user, User $model)
    {
        //
    }
}
