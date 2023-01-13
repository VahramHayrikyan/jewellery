<?php

namespace App\Http\Resources\SiteData;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteImageCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $siteData['slide'] = [];
        $siteData['banners'] = [];

        foreach ($this->collection as $item) {
            if ($item['type'] === 'banner') {
                array_push($siteData['banners'], $item->path);
            } else {
                array_push($siteData['slide'], $item->path);
            }
        }

        return $siteData;
    }
}
