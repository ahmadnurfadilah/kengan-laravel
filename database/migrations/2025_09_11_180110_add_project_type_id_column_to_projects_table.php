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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('type_id')->nullable()->constrained('project_types')->onDelete('cascade')->after('twitter_id');
            $table->foreignId('category_id')->nullable()->constrained('project_categories')->onDelete('cascade')->after('type_id');
            $table->string('discord')->nullable()->after('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('type_id');
            $table->dropColumn('category_id');
        });
    }
};
