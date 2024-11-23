<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Diamond;
use Illuminate\Http\Request;

class DiamondController extends Controller
{
    public function getDiamonds(){
        $plans=Diamond::where('is_active',1)->get();
        $plans->each(function($plan){
            $plan->mrp = (int) $plan->mrp;
            $plan->selling_price = (int) $plan->selling_price;
        });
        return response()->json([
            'data'=>$plans,
            'status'=> true,
            'message'=>'Diamonds retrieved successfully'
        ]);
    }
}
