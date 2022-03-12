<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        try {
            $reservation = $request->only(['shop_id', 'date', 'time', 'number']);
            $reservation['user_id'] = Auth::id();
            Reservation::create($reservation);

            return response()->json([
                'message' => '予約を作成しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function update(ReservationRequest $request)
    {
        try {
            $reservation = $request->only(['date', 'time', 'number']);
            Reservation::find($request->reservation_id)->update($reservation);

            return response()->json([
                'message' => '予約を更新しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        try {
            Reservation::find($request->reservation_id)->delete();

            return response()->json([
                'message' => '予約を削除しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
