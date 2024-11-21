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
        Schema::create('live_vide_calls', function (Blueprint $table) {
            $table->id();
            $table->string('live_id');
            $table->foreignId('user_id')->constrained('customers')->onDelete('cascade');
            $table->string('user_name')->nullable();
            $table->string('live_status')->nullable();
            $table->dateTime('live_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_vide_calls');
    }
};
