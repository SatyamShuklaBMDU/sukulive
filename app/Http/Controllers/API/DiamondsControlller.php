<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerDiamonds;
use App\Models\Diamond;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DiamondsControlller extends Controller
{
    public function purchaseDiamonds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diamond_id' => 'required|exists:diamonds,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        $customer = auth()->user();
        $diamond = Diamond::find($request->diamond_id);

        if (!$diamond || !$diamond->is_active) {
            return response()->json(['message' => 'Diamond package not available'], 404);
        }

        $wallet = Wallet::where('customer_id', $customer->id)->first();

        if (!$wallet || $wallet->balance < $diamond->selling_price) {
            return response()->json(['message' => 'Insufficient balance in wallet'], 400);
        }
        $wallet->balance -= $diamond->selling_price;
        $wallet->save();
        Transaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $diamond->selling_price,
            'transaction_type' => 'debit',
            'description' => "Purchase of {$diamond->diamonds} diamonds",
        ]);
        $customerDiamonds = CustomerDiamonds::firstOrCreate(
            ['customer_id' => $customer->id],
            ['total_diamonds' => 0, 'used_diamonds' => 0, 'available_diamonds' => 0]
        );

        $customerDiamonds->total_diamonds += $diamond->diamonds;
        $customerDiamonds->available_diamonds += $diamond->diamonds;
        $customerDiamonds->save();

        return response()->json([
            'message' => 'Purchase successful',
            'diamonds' => $diamond->diamonds,
            'remaining_balance' => $wallet->balance,
            'total_diamonds' => $customerDiamonds->total_diamonds,
            'available_diamonds' => $customerDiamonds->available_diamonds,
        ]);
    }

    public function getDiamonds()
    {
        $user = Auth::user();
        $balance = $user->diamonds->available_diamonds;
        $data['balance'] = $balance;
        return response()->json($data, Response::HTTP_OK);
    }
}
