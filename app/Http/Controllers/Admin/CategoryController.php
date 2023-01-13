<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\Save;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends AdminBaseController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $categories = Category::whereNull('parent_id')->with(['children'])->get();

        return $this->success(new CategoryCollection($categories));
    }

    public function store(Save $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return $this->success(new CategoryResource($category), 201);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->success(new CategoryResource($category));
    }

    public function update(Save $request, Category $category): JsonResponse
    {
        $category->update($request->except(['id', 'category']));

        return $this->success(new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        DB::beginTransaction();
        $subcategoryIds = $this->productService->getSubcategoryIds($category->id);
        $category->delete();
        $category->products()->detach();
        $category->children()->delete();
        DB::table('category_product')->whereIn('category_id', $subcategoryIds)->delete();
        DB::commit();

        return $this->success();
    }
}
