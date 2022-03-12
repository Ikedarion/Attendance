<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CartItemController extends Controller
{
    public function index()
    {
        try {
            $cart_items = CartItem::userSearch()->get();

            $subtotal = 0;
            foreach ($cart_items as $cart_item) {
                $subtotal += $cart_item->item->price * $cart_item->quantity;
            }

            return response()->json([
                'cart_items' => $cart_items,
                'subtotal' => $subtotal
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function store(CartItemRequest $request)
    {
        try {
            CartItem::updateOrCreate(
                ['item_id' => $request->item_id, 'user_id' => Auth::id()],
                ['quantity' => $request->quantity]
            );

            return response()->json([
                'message' => 'カートに追加しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function update(CartItemRequest $request)
    {
        try {
            $cart_item = $request->only(['quantity']);

            CartItem::find($request->cart_item_id)->update($cart_item);

            return response()->json([
                'message' => 'カートを更新しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        try {
            CartItem::find($request->cart_item_id)->delete();

            return response()->json([
                'message' => 'カートから削除しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
