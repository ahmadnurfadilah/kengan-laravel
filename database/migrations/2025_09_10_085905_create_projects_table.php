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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('twitter_id')->nullable()->index();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('avatar_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('bio')->nullable();
            $table->string('website')->nullable();
            $table->integer('total_followers')->default(0);
            $table->integer('total_following')->default(0);
            $table->integer('total_tweets')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
