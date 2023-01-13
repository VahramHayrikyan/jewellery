<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\SiteData\ProductGroupCollection;
use App\Http\Resources\SiteData\SiteImageCollection;
use App\Models\Category;
use App\Models\ProductGroup;
use App\Models\SiteImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = Category::whereNull('parent_id')->with(['children'])->get();

        return $this->success(new CategoryCollection($categories));
    }

    public function siteData(Request $request): JsonResponse
    {
        $siteImages = SiteImage::all();
        $productGroups = ProductGroup::all();

        $siteImages = (new SiteImageCollection($siteImages))->toArray($request);
        $productGroups = (new ProductGroupCollection($productGroups))->toArray($request);
        $returnData = array_merge($siteImages, $productGroups);

        return $this->success($returnData);
    }
}
