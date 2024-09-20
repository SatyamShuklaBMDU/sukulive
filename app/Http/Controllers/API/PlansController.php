<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function getPlans(){
        $plans=Plan::where('is_active',1)->get();
        return response()->json([
            'data'=>$plans,
            'status'=> true,
            'message'=>'Plans retrieved successfully'
        ]);
    }
}
