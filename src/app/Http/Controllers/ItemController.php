<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Throwable;

class ItemController extends Controller
{
    public function index()
    {
        try {
            return Item::all();
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        try {
            return Item::find($request->item_id);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function search(Request $request)
    {
        try {
            return Item::search($request->keyword)->get();
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
