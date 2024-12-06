<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function handleSuccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "rozarpay_id" => "string|sometimes",
            "amount" => "sometimes|numeric|min:1",
            "currency" => "sometimes|string",
            "rozarpay_payment_status" => "string|sometimes",
            "reciept" => "sometimes|string",
            "order_id" => "sometimes|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $customer = auth()->user();
        $wallet = $customer->wallet;
        $data = [
            "rozarpay_id" => $request->rozarpay_id,
            "amount" => $request->amount,
            "currency" => $request->currency,
            "rozarpay_payment_status" => $request->rozarpay_payment_status,
            "reciept" => $request->reciept,
            "order_id" => $request->order_id,
            "description" => "Payment added via RozarPay",
        ];
        try {
            $this->walletService->credit($wallet, $data);
            return response()->json([
                "success" => true,
                'message' => 'Wallet credited successfully.',
                'balance' => $wallet->balance,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to process the payment. Please try again.',
                'details' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handlefailure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:1',
            'rozarpay_payment_status' => 'sometimes|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        $customer = auth()->user();
        $wallet = $customer->wallet;
        $data = [
            'reason' => $request->reason,
            'amount' => $request->amount,
            'rozarpay_payment_status' => $request->rozarpay_payment_status,
        ];
        Log::error('Razorpay Payment Failure', $request->all());
        try {
            $this->walletService->debit($wallet, $data);
            return response()->json([
                'success' => true,
                'message' => 'Payment failed successfully.',
            ],Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment failed. Please try again.',
                'error_details' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
