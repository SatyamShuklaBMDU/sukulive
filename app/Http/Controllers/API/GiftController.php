<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        $gift = Gift::where("is_active", true)->orderBy("id", "desc")->get();
        $path = "https://sukulive.com/";
        $gift->each(function ($gift) use ($path) {
            $gift->image = $gift->image ? $path . $gift->image : '';
        });
        return response()->json($gift, 200);
    }
}
