<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Attribite\SaveRequest;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AttributeController extends AdminBaseController
{
    public function index(): JsonResponse
    {
        $attributes = Attribute::with('attributeValues')->get();

        return self::success($attributes);
    }

    public function store(SaveRequest $request): JsonResponse
    {
        return self::success(Attribute::create($request->validated()));
    }

    public function show(Attribute $attribute): JsonResponse
    {
        return self::success($attribute);
    }

    public function update(SaveRequest $request, Attribute $attribute): JsonResponse
    {
        $attribute->update($request->validated());

        return self::success($attribute);
    }

    public function destroy(Attribute $attribute): JsonResponse
    {
        if ($attribute->id === 1) return self::error('you can\'t delete size attribute');
        DB::beginTransaction();
        $attribute->delete();
        foreach ($attribute->attributeValues as $item) {
            $item->products()->detach();
            $item->delete();
        }
        DB::commit();

        return self::success();
    }
}
