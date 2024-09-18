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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name
            $table->decimal('price', 10, 2); // Plan price
            $table->enum('duration', ['monthly', 'yearly', 'weekly'])->default('monthly'); // Plan duration
            $table->text('features')->nullable(); // Plan features (could be a JSON or text list)
            $table->enum('plan_type', ['free', 'paid'])->default('paid'); // Free or Paid plan
            $table->integer('trial_period_days')->default(0); // Optional trial period
            $table->string('promotion_code')->nullable(); // Optional promotion or discount code
            $table->boolean('is_active')->default(true); // Plan status (active/inactive)
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
