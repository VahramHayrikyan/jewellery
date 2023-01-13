<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AttribiteValue\SaveRequest;
use App\Models\AttributeValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends AdminBaseController
{
    public function store(SaveRequest $request): JsonResponse
    {
        return self::success(AttributeValue::create($request->validated()));
    }

    public function show(AttributeValue $attributeValue): JsonResponse
    {
        return self::success($attributeValue);
    }

    public function update(Request $request, AttributeValue $attributeValue): JsonResponse
    {
        $attributeValue->name = $request->name;
        $attributeValue->save();

        return self::success($attributeValue);
    }

    public function destroy(AttributeValue $attributeValue): JsonResponse
    {
        DB::beginTransaction();
        $attributeValue->delete();
        $attributeValue->products()->detach();
        DB::commit();

        return self::success();
    }
}
