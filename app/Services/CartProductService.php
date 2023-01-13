<?php

namespace App\Services;

use App\Models\CartProduct;
use Exception;

Class CartProductService extends BaseService
{
    public function getById($id)
    {
        $CartProduct = CartProduct::find($id);
        if (!$CartProduct) {
            throw new Exception('Cart Product not found.');
        }

        return $CartProduct;
    }

    public static function getTotalPrice($products)
    {
        return $products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->unit_price;
        });
    }
}
