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
        Schema::create('gift_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('gift_id');
            $table->integer('diamonds');
            $table->foreign('sender_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_histories');
    }
};
