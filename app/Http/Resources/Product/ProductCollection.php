<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $products = [];

        foreach ($this->collection as $product) {

            array_push($products, [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->slug,
                'price' => $product->price,
                'code' => $product->code,
                'attachments' => $product->attachments,
                'attribute_values' => $product->attributeValues
            ]);

        }

        return $products;
    }
}
