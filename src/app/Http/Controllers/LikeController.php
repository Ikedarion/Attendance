<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $like = $request->only(['shop_id']);
            $like['user_id'] = Auth::id();

            Like::create($like);

            return response()->json([
                'message' => 'お気に入りに追加しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        try {
            Like::find($request->like_id)->delete();

            return response()->json([
                'message' => 'お気に入りから削除しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
