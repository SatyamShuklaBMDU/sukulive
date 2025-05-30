<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('rozarpay_id')->nullable();
            $table->string('order_id')->nullable();
            $table->enum('rozarpay_payment_status', ['success','failure'])->default('success');
            $table->string('currency')->nullable();
            $table->string('reciept')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->enum('transaction_type', ['credit','debit'])->nullable();
            $table->text('failure_reason')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
