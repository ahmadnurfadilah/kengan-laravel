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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('twitter_handle')->nullable()->index();
            $table->enum('status', ['draft', 'pending', 'active', 'completed'])->default('draft');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->jsonb('required_mentions')->nullable();
            $table->jsonb('required_keywords')->nullable();
            $table->jsonb('required_hashtags')->nullable();

            $table->double('reward_amount')->default(0);
            $table->string('reward_currency')->default('IDR');

            $table->string('topic_objective')->nullable();

            $table->string('website')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('cover_url')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
