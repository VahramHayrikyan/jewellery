<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AttribiteValue\SaveAVProductRequest;
use App\Models\AttributeValue;
use App\Models\AttributeValueProduct;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeValueProductController extends AdminBaseController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(SaveAVProductRequest $request): JsonResponse
    {
        if ($request->price) {
            if (AttributeValue::find($request->attribute_value_id)->attribute->id !== 1)
                return self::error('Only size can have custom price.');
            $product = $this->productService->getById($request->product_id);
            if (intval($product->price) + intval($request->price) <= 0)
                return self::error('Price can\'t be negative value or equal to zero.');
        }
        return self::success(AttributeValueProduct::create($request->validated()));
    }

    public function update(Request $request, AttributeValueProduct $attributeValueProduct): JsonResponse
    {
        if ($attributeValueProduct->attributeValue->attribute->id !== 1) {
            return self::error('Only size can have custom price.');
        }
        $product = $this->productService->getById($attributeValueProduct->product_id);
        if (intval($product->price) + intval($request->price) <= 0)
            return self::error('Price can\'t be negative value or equal to zero.');

        $attributeValueProduct->price = $request->price;
        $attributeValueProduct->save();
        $attributeValueProduct->refresh();

        return self::success($attributeValueProduct);
    }

    public function destroy(AttributeValueProduct $attributeValueProduct): JsonResponse
    {
        $attributeValueProduct->delete();

        return self::success();
    }
}
