<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\ClientRepository;
use Exception;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['password'] = bcrypt($request->password);

            $user = User::create($validatedData);
            $user->sendEmailVerificationNotification();

            DB::commit();
            return $this->success(['user' => $user]);
        } catch (Exception $exception) {
            return self::error($exception->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse//$user = Auth::guard('user-api')->user(); $user ->token()->revoke();
    {
        try {
            if (!auth()->attempt($request->validated())) {
                return self::error(['message' => 'Invalid Credentials']);
            }

            if (!auth()->user()->email_verified_at) {
                return self::error(['message' => 'NOT ACTIVE']);
            }

            $this->setClient(config('auth.clients.users.id'));
            $accessToken = auth()->user()->createToken('userToken')->accessToken;

            return $this->success(['token' => $accessToken]);

        } catch (Exception $exception) {
            return $this->error(['message' => $exception->getMessage()]);
        }
    }

    public function adminLogin(LoginRequest $request): JsonResponse
    {
        try {
            $admin = Admin::whereEmail($request->email)->first();

            if (!$admin) {
                return $this->error(['message' => 'Invalid Credentials'], 401);
            }
            if(!Hash::check($request->password, $admin->password)){
                return $this->error(['message' => 'Invalid Credentials'], 401);
            }

            $this->setClient(config('auth.clients.admins.id'));
            $accessToken =  $admin->createToken('adminToken')->accessToken;
            return $this->success(['token' => $accessToken]);
        } catch (Exception $exception) {
            return $this->error(['message' => $exception->getMessage()]);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return self::success();
    }

    private function setClient($clientId)
    {
        App::clearResolvedInstance(ClientRepository::class);
        app()->singleton(ClientRepository::class, function () use ($clientId) {
            return new ClientRepository($clientId);
        });
    }

}
