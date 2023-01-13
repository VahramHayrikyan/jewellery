<?php

namespace App\Http\Resources\CartProduct;

use App\Models\AttributeValueCartProduct;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CartProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $products = [];
        $currentCart = $this;
        $this->collection = $currentCart->products;

        foreach ($this->collection as $product) {
            //get selected attribute value ids
            $currentAttributeValueIds = AttributeValueCartProduct::where('cart_product_id', $product->pivot->id)->pluck('attribute_value_id')->toArray();
            //get selected attribute values
            $currentProductAttributeValues = $product->load(['attributeValues' => function ($q) use ($currentAttributeValueIds) {
                return $q->whereIn('attribute_value_id', $currentAttributeValueIds);
            }])->attributeValues;

            array_push($products, [
                'id' => $product->pivot->id,
                'name' => $product->name,
                'code' => $product->code,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price,
                'comment' => $product->pivot->comment,
                'total_price' => $product->pivot->quantity * $product->pivot->unit_price,
                'attachment' => $product->firstAttachment,
                'attributes' => $currentProductAttributeValues->mapToGroups(function ($item, $key) {
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
