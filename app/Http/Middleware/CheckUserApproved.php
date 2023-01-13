<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproved
{
    use Response;

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user();

        if ($user && $user->approved) {
            return $next($request);
        } else {
            return $this->error(['message' => 'User not approved.']);
        }

    }
}
