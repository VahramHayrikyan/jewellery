<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Exception;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(): JsonResponse
    {
        return $this->success(auth()->user());
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $data = $request->validated();
            if (!$request->password) {
                unset($data['password']);
                unset($data['old_password']);
                unset($data['password_confirmation']);
                $user->update($data);
            }
            else $this->userService->update($data, $user);

            return self::success($user);
        } catch(Exception $exception) {
            return self::error($exception->getMessage());
        }
    }
}
