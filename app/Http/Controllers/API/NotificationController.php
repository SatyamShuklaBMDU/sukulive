<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   

    public function index(Request $request)
    {
        $notifications = Notification::where('for', 'all')->latest()->get();
        if ($notifications->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'empty'], 404);
        }
        return response()->json(['status' => true, 'data' => $notifications], 200);
    }

}
