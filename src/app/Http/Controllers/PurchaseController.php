<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\PurchaseDetail;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PurchaseController extends Controller
{
    public function store()
    {
        try {
            DB::beginTransaction();

            $cart_items = CartItem::userSearch()->get();

            if ($cart_items->isEmpty()) {
                return response()->json([
                    'message' => 'カートに商品がありません'
                ]);
            }

            $purchase_history = PurchaseHistory::create([
                'user_id' => Auth::id()
            ]);

            foreach ($cart_items as $cart_item) {
                PurchaseDetail::create([
                    'item_id' => $cart_item->item->id,
                    'purchase_history_id' => $purchase_history->id,
                    'quantity' => $cart_item->quantity
                ]);

                CartItem::find($cart_item->id)->delete();
            }

            DB::commit();

            return response()->json([
                'message' => '購入が完了しました'
            ]);
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }
}
