<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGroup\SaveRequest;
use App\Models\ProductGroup;
use Illuminate\Http\JsonResponse;

class ProductGroupController extends Controller
{
    public function index(): JsonResponse
    {
        return self::success(ProductGroup::with('product')->get());
    }

    public function store(SaveRequest $request): JsonResponse
    {
        return self::success(ProductGroup::create($request->validated()));
    }

    public function destroy(ProductGroup $productGroup): JsonResponse
    {
        $productGroup->delete();

        return self::success();
    }
}
