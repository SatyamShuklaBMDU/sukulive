<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerDiamonds;
use App\Models\Gift;
use App\Models\GiftHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        $gift = Gift::where("is_active", true)->orderBy("id", "desc")->get();
        $path = "https://sukulive.com/";
        $gift->each(function ($gift) use ($path) {
            $gift->image = $gift->image ? "{$path}{$gift->image}" : '';
        });
        return response()->json($gift, 200);
    }

    public function sendGift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gift_id' => 'required|exists:gifts,id',
            'user_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $loggedInUser = auth()->user();
        $receiverId = $request->user_id;
        $gift = Gift::find($request->gift_id);
        $diamondCost = $gift->price;
        $senderWallet = $loggedInUser->diamonds;

        if (!$senderWallet || $senderWallet->available_diamonds < $diamondCost) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have enough diamonds to send this gift.'
            ], 400);
        }
        $receiverWallet = CustomerDiamonds::firstOrCreate(
            ['customer_id' => $receiverId],
            ['total_diamonds' => 0, 'used_diamonds' => 0, 'available_diamonds' => 0]
        );
        $senderWallet->used_diamonds += $diamondCost;
        $senderWallet->available_diamonds -= $diamondCost;
        $senderWallet->save();
        $receiverWallet->total_diamonds += $diamondCost;
        $receiverWallet->available_diamonds += $diamondCost;
        $receiverWallet->save();

        GiftHistory::create([
            'sender_id' => $loggedInUser->id,
            'receiver_id' => $receiverId,
            'gift_id' => $gift->id,
            'diamonds' => $diamondCost,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gift sent successfully.',
            'data' => [
                'sender_id' => $loggedInUser->id,
                'receiver_id' => $receiverId,
                'gift_id' => $request->gift_id,
                'sender_remaining_diamonds' => $senderWallet->available_diamonds,
                'receiver_total_diamonds' => $receiverWallet->total_diamonds,
            ]
        ]);
    }

    public function receiverleaderboard(Request $request)
    {
        $timeFilter = $request->input('filter', 'today');
        $startDate = match ($timeFilter) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            default => now()->startOfDay(),
        };
        $leaderboard = GiftHistory::where('created_at', '>=', $startDate)
            ->select('receiver_id', DB::raw('SUM(diamonds) as total_diamonds'))
            ->groupBy('receiver_id')
            ->orderByDesc('total_diamonds')
            ->take(10)
            ->with('receiver')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $leaderboard,
        ]);
    }

    public function senderleaderboard(Request $request)
    {
        $timeFilter = $request->input('filter', 'today');
        $startDate = match ($timeFilter) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            default => now()->startOfDay(),
        };
        $leaderboard = GiftHistory::where('created_at', '>=', $startDate)
            ->select('sender_id', DB::raw('SUM(diamonds) as total_spent'))
            ->groupBy('sender_id')
            ->orderByDesc('total_spent')
            ->take(10)
            ->with('sender')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leaderboard,
        ]);
    }
}
