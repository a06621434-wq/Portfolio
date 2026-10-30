<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the projects table for the Shahzad Labs portfolio showcase.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->json('tech_stack');          // e.g. ["Laravel","MySQL","Tailwind"]
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('category');          // laravel, frontend, fullstack, saas
            $table->string('metric')->nullable(); // e.g. "50% faster load time"
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
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
