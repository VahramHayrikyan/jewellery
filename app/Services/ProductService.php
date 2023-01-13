<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

Class ProductService extends BaseService
{
    public function getById($id)
    {
        return Product::find($id);
    }

    public function store(array $data, array $categoryIds)
    {
        DB::beginTransaction();
        $product = Product::create($data);
        $product->categories()->sync($categoryIds);
        DB::commit();

        return $product;
    }

    public function update(array $data, array $categoryIds, $product)
    {
        DB::beginTransaction();
        $product->update($data);
        $product->categories()->sync($categoryIds);
        DB::commit();

        return $product;
    }

    public function getSubcategoryIds($categoryId): array
    {
        return Category::where('parent_id', $categoryId)->pluck('id')->toArray();
    }
}
