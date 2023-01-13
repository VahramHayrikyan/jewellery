<?php

namespace App\Http\Resources\SiteData;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductGroupCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $siteData['best_sellers'] = [];
        $siteData['new'] = [];

        foreach ($this->collection as $item) {
            if ($item['type'] === 'new') {
                array_push($siteData['new'], new ProductResource($item->product));
            } else {
                array_push($siteData['best_sellers'], new ProductResource($item->product));
            }
        }

        return $siteData;
    }
}
