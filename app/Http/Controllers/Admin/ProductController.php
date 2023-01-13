<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Save;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $products = Product::with(['attachments', 'attributeValues'])->get();

        return $this->success(new ProductCollection($products));
    }

    public function store(Save $request): JsonResponse
    {
        $product = $this->productService->store($request->validated(), $request->category_ids);

        return $this->success(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->success(new ProductResource($product));
    }

    public function update(Save $request, Product $product): JsonResponse
    {
        $this->productService->update($request->validated(), $request->category_ids, $product);

        return $this->success(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        DB::beginTransaction();
        $product->delete();
        $product->productGroups()->delete();
        $product->categories()->detach();
        DB::commit();

        return $this->success();
    }
}
