<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;
use Throwable;

class ShopController extends Controller
{
    public function index()
    {
        try {
            $shops = Shop::with(['area', 'genre', 'users'])->paginate(8);
            $areas = Area::all();
            $genres = Genre::all();

            return response()->json([
                'shops' => $shops,
                'areas' => $areas,
                'genres' => $genres,
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function search(Request $request)
    {
        try {
            $shops = Shop::with(['area', 'genre', 'users'])->areaSearch($request->area_id)->genreSearch($request->genre_id)->keywordSearch($request->keyword)->paginate(8);
            $areas = Area::all();
            $genres = Genre::all();

            return response()->json([
                'shops' => $shops,
                'areas' => $areas,
                'genres' => $genres,
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        try {
            return Shop::with(['area', 'genre'])->find($request->shop_id);
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
