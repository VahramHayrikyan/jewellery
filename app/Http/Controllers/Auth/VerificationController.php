<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{
    public function verify(Request $request, $userId) {
        if (!$request->hasValidSignature()) return self::error('Invalid/Expired url provided.', 401);

        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to(config('app.front_url'));
    }

    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) return self::error('Email already verified.');

        auth()->user()->sendEmailVerificationNotification();

        return self::success('Email verification link sent on your email id');
    }
}
