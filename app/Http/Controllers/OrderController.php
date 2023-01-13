<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CheckoutRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): JsonResponse
    {
        $orders = auth()->user()->orders;

        return self::success(new OrderCollection($orders));
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        $cart = $this->cartService->getLastCart();
        if (!$cart) return self::error('Cart not found.');

        $order = new Order();
        $order->cart_id = $cart->id;
        $order->bank_status = 'ok';//todo check
        $order->payment_status = 0;
        $order->status = null;
        $order->preorder = $request->preorder;
        $order->save();

        if (!$order->preorder) {
            //todo payment
            return self::success($order);
        }

        return self::success($order);
    }
}
