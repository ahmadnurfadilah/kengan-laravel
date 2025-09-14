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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 50)->unique();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('payable');
            $table->double('amount');
            $table->string('currency')->default('USDT');
            $table->string('chain_id')->nullable();
            $table->string('sender_address')->nullable();
            $table->string('treasure_address')->nullable();
            $table->string('transaction_hash')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'canceled'])->default('pending');
            $table->json('meta')->nullable();
            $table->foreignUuid('verified_by')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
