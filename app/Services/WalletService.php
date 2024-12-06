<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function credit(Wallet $wallet, array $data): Transaction
    {
        return DB::transaction(function () use ($wallet, $data) {
            $wallet->balance += $data["amount"];
            $wallet->save();

            return $wallet->transactions()->create([
                "amount" => $data["amount"],
                "rozarpay_id" => $data["rozarpay_id"],
                "order_id" => $data["order_id"],
                "rozarpay_payment_status" => $data["rozarpay_payment_status"],
                "currency" => $data["currency"],
                "reciept" => $data["reciept"],
                "transaction_type" => "credit",
                "description" => $data["description"],
            ]);
        });
    }

    public function debit(Wallet $wallet, array $data): Transaction
    {
        if ($wallet->balance > $data['amount']) {
            throw new \Exception('Insufficient wallet balance.');
        }

        return DB::transaction(function () use ($wallet, $data) {
            $wallet->balance -= $data['amount'];
            $wallet->save();

            return $wallet->transactions()->create([
                "amount" => $data['amount'],
                'currency' => $data['currency'],
                'transaction_type' => 'debit',
                'decription' => $data['description']
            ]);
        });
    }

    public function failed(Wallet $wallet, array $data): Transaction
    {
        return DB::transaction(function () use ($data, $wallet) {
            return $wallet->transactions()->create([
                'amount' => $data['amount'],
                'rozarpay_payment_status' => $data['rozarpay_payment_status'],
                'failure_reason' => $data['failure_reason'],
            ]);
        });
    }
}
