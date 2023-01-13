<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends AdminBaseController
{
    private LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->success(new UserCollection($users));
    }

    public function show(User $user): JsonResponse
    {
        return $this->success(new UserResource($user));
    }

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        DB::beginTransaction();
        $this->logService->store(['group_id' => $user->group_id, 'comment' => $user->comment], $request->validated());
        $user->group_id = $request->group_id;
        $user->comment  = $request->comment;
        $user->approved = $request->approved;
        $user->save();
        DB::commit();

        return $this->success(new UserResource($user));
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->success();
    }
}
