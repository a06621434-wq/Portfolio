<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates skills table for managing technical proficiencies in Shahzad Labs.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // e.g. "Laravel", "PHP", "MySQL"
            $table->string('category');                  // backend, frontend, database, devops, tools
            $table->unsignedTinyInteger('proficiency')->default(85); // 1-100 percentage
            $table->string('icon')->nullable();          // emoji or icon representation
            $table->string('experience')->nullable();    // e.g. "5+ Years", "3 Years"
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
