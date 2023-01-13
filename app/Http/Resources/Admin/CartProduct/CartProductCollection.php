<?php

namespace App\Http\Resources\Admin\CartProduct;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartProductCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $products = [];

        foreach ($this->collection as $product) {
            array_push($products, [
                'name' => $product->name,
                'code' => $product->code,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price,
                'total_price' => $product->pivot->quantity * $product->pivot->unit_price,
                'attachment' => $product->firstAttachment,
            ]);
        }

        return $products;
    }
}
