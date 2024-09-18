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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // User who subscribed
            $table->foreignId('plan_id')->constrained()->onDelete('cascade'); // The plan the user subscribed to
            $table->timestamp('started_at')->nullable(); // Subscription start date
            $table->timestamp('expires_at')->nullable(); // Subscription expiry date
            $table->boolean('is_active')->default(true); // Active/inactive subscription status
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
