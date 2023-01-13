<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateRequest;
use App\Http\Resources\Admin\Order\OrderCollection;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::all();

        return self::success(new OrderCollection($orders));
    }

    public function update(UpdateRequest $request, Order $order): JsonResponse
    {
        $order->update(['status' => $request->status]);

        return self::success($order);
    }
}
