<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->discount,
            'code' => $this->code,
            'attachments' => $this->attachments,
            'attributes' => $this->attributeValues,
            'categories' => $this->categories,
        ];
    }
}
