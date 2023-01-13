<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Mail\ForgotPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends BaseController
{
    public function forgotPassword(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            'email' => 'required|exists:users'
        ]);

        $tempPassword = get_random_code(12);
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($tempPassword);
        $user->save();

        Mail::to($request->email)->send(new ForgotPasswordEmail($tempPassword));

        DB::commit();
        return self::success(['message' => 'We sent random generated password to your email.']);
    }
}
