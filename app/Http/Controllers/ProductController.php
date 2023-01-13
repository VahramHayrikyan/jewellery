<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function getAll(Request $request): JsonResponse
    {
        $products = Product::with(['attachments', 'categories', 'attributeValues.attribute'])->filter($request)->orderBy('id', 'desc')->get();

        if ($request->user()->group_id) {//if in group, update prices
            foreach ($products as $product) {
                $discount = max($request->user()->group->discount, $product->discount);
                $product->price = get_by_percent($product->price, $discount);
                $product->discount = $discount;
                $attributes = $product->attributeValues->mapToGroups(function ($item, $key) {
                    return [$item['attribute']['name'] => [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['pivot']['price'],
                    ]];
                });
                unset($product['attributeValues']);
                $product->attributes = $attributes;
            }
        }

        return $this->success($products);
    }
}
