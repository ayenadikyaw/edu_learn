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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('profile_image')->nullable(); // Nullable in case no image is provided
            $table->decimal('price', 8, 2); // Example: 999999.99
            $table->string('level'); // Beginner, Intermediate, Advanced
            $table->string('category'); // Example: Development, Business, Design
            $table->integer('duration'); // Duration in minutes or hours
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
