<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\SaveRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AddressController extends BaseController
{
    public function index(): JsonResponse
    {
        return self::success(auth()->user()->addresses);
    }

    public function store(SaveRequest $request): JsonResponse
    {
        DB::beginTransaction();
        auth()->user()->addresses()->where('type', $request->type)->delete();
        $address = auth()->user()->addresses()->create($request->validated());
        DB::commit();

        return self::success($address);
    }

    public function show($id): JsonResponse
    {
        return self::success(auth()->user()->addresses);
    }

    public function update(SaveRequest $request, Address $address): JsonResponse
    {
        $address->update($request->validated());

        return self::success($address);
    }

    public function destroy(Address $address): JsonResponse
    {
        $this->authorize('delete-address', $address);
        $address->delete();

        return self::success();
    }
}
