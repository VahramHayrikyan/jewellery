<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\CartProduct\CartProductCollection;
use App\Services\CartProductService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $orders = [];

        foreach ($this->collection as $order) {
            $cart = $order->cart;
            $products = $cart->products;

            array_push($orders, [
                'id' => $order->id,
                'bank_status' => $order->bank_status,
                'payment_status' => $order->payment_status,
                'status' => $order->status,
                'preorder' => $order->preorder,
                'total_price' => CartProductService::getTotalPrice($products),
                'date' => $order->created_at,
                'cart_products' => new CartProductCollection($products)
            ]);
        }

        return $orders;
    }
}
