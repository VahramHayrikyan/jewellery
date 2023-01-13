<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(): JsonResponse
    {
        return self::success(Log::with('admin')->get());
    }
}
