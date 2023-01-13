<?php

namespace App\Http\Resources\CartProduct;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartProductCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $products = [];

        foreach ($this->collection as $product) {
            array_push($products, [
                'id' => $product->pivot->id,
                'name' => $product->name,
                'code' => $product->code,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price,
                'comment' => $product->pivot->comment,
                'total_price' => $product->pivot->quantity * $product->pivot->unit_price,
                'attachment' => $product->firstAttachment,
                'attributes' => $product->attributeValues->mapToGroups(function ($item, $key) {
                    return [$item['attribute']['name'] => [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['pivot']['price'],
                    ]];
                }),
            ]);
        }

        return $products;
    }
}
