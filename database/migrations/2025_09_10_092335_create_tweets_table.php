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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->onDelete('cascade');
            $table->string('tweet_id')->index();

            $table->text('text')->nullable();
            $table->tinyInteger('sentiment')->nullable()->index();

            $table->integer('total_view')->default(0);
            $table->integer('total_like')->default(0);
            $table->integer('total_retweet')->default(0);
            $table->integer('total_reply')->default(0);
            $table->integer('total_quote')->default(0);
            $table->double('points')->default(0);

            $table->timestamp('sentiment_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
