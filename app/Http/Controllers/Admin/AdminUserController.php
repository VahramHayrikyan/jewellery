<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminUser\UpdateRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUserController extends AdminBaseController
{
    public function index(): JsonResponse
    {
        $adminUsers = Admin::where('id', '<>', auth()->user()->id)->get();
        return $this->success($adminUsers);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Admin $admin)
    {
        return $this->success($admin);
    }

    public function update(UpdateRequest $request, Admin $admin)
    {
        $admin->update(['role_id' => $request->role_id]);

        return $this->success($admin);
    }

    public function destroy(Admin $admin)
    {
        $this->authorize('delete-admin', $admin);

        $admin->delete();

        return $this->success();
    }

    public function roles(): JsonResponse
    {
        return $this->success(Admin::ROLES);
    }
}
