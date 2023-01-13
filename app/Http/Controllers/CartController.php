<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProduct\SaveRequest;
use App\Http\Resources\CartProduct\CartProductCollection;
use App\Http\Resources\CartProduct\CartProductResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Services\CartProductService;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CartController extends BaseController
{
    private CartService $cartService;
    private CartProductService $cartProductService;

    public function __construct(CartService $cartService, CartProductService $cartProductService)
    {
        $this->cartService = $cartService;
        $this->cartProductService = $cartProductService;
    }

    public function index(): JsonResponse
    {
        $currentCart = $this->cartService->getLastCart();

        if ($currentCart) return $this->success(new CartProductResource($currentCart));
        else return $this->success();
    }

    //only size attribute can have custom price
    public function store(SaveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $cart = $this->cartService->getLastCart();

            if (!$cart) $cart =  $this->cartService->store();
            $price = $this->cartService->getPrice($request->product_id, $request->attribute_value_ids);

            $cartProduct = CartProduct::where([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
            ])->first();

            if ($cartProduct) {
                $cartProduct->quantity += $request->quantity;
                $cartProduct->unit_price = $price;
                $cartProduct->comment = $request->comment;
                $cartProduct->save();
            } else {
                $cart->products()->attach($request->product_id, [
                    'cart_id' => $cart->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $price,
                    'comment' => $request->comment,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                //jun :D
                $cartProduct = CartProduct::where([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                ])->first();
            }

            $cartProduct->attributeValues()->sync($request->attribute_value_ids);
            DB::commit();

            return $this->success($cart->products, 201);
        } catch (Exception $exception) {
            return self::error($exception->getMessage());
        }
    }

    public function show(Cart $cart): JsonResponse
    {
        $this->authorize('access-cart', $cart);
        return $this->success(['cart' => $cart]);
    }

    public function update(SaveRequest $request, $cartProductId): JsonResponse
    {
        try {
            $cartProduct = $this->cartProductService->getById($cartProductId);
            $this->authorize('access-cartProduct', $cartProduct);
            $cartProduct->update(['quantity' => $request->quantity, 'comment' => $request->comment]);

            return self::success($cartProduct);
        } catch (Exception $exception) {
            return self::error($exception->getMessage());
        }
    }

    public function destroy(Request $request, $cartProductId): JsonResponse
    {
        try {
            $cartProduct = $this->cartProductService->getById($cartProductId);
            $this->authorize('access-cartProduct', $cartProduct);
            $cartProduct->delete();

            return self::success();
        } catch (Exception $exception) {
            return self::error($exception->getMessage());
        }
    }
}
