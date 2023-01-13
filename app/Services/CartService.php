<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

Class CartService extends BaseService
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getLastCart()
    {
        return Cart::userCarts()
            ->whereDoesntHave('order')->orderBy('id', 'desc')->first();
    }

    //get product discount price if user is in group
    //check price based on size
    //get minimum of group or size
    public function getPrice($productId, $attributeValueIds)
    {
        $userGroup = request()->user()->group;
        $product = $this->productService->getById($productId);
        $price = $product->price;
        if ($attributeValueIds) {
            $priceSumBasedOnAttributes = $product->load(['attributeValues' => function ($q) use ($attributeValueIds) {
                return $q->whereIn('attribute_value_id', $attributeValueIds);
            }])->attributeValues->sum('pivot.price');
        }


        if ($userGroup) {
            $price = get_by_percent($product->price, $userGroup->discount);
        }
        if ($product->discount) {
            $discountedPrice = get_by_percent($product->price, $product->discount);
            $price = min($price, $discountedPrice);
        }

        return $attributeValueIds ? $price + $priceSumBasedOnAttributes : $price;
    }

    public function store()
    {
        return Cart::create(['user_id' => auth()->user()->id]);
    }
}
