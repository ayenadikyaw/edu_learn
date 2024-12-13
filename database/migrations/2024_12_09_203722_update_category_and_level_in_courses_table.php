<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // // Add temporary columns for IDs
        // Schema::table('courses', function (Blueprint $table) {
        //     $table->unsignedBigInteger('new_category_id')->nullable();
        //     $table->unsignedBigInteger('new_level_id')->nullable();
        // });

        // Map existing string values to IDs in new columns
        DB::statement('
            UPDATE courses
            SET new_category_id = (
                SELECT id FROM course_categories WHERE course_categories.name = courses.category_id
            )
        ');

        DB::statement('
            UPDATE courses
            SET new_level_id = (
                SELECT id FROM course_levels WHERE course_levels.name = courses.level_id
            )
        ');

        // Drop old columns
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'level_id']);
        });

        // Rename temporary columns to match original names
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('new_category_id', 'category_id');
            $table->renameColumn('new_level_id', 'level_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate original string columns
        Schema::table('courses', function (Blueprint $table) {
            $table->string('category_id')->nullable();
            $table->string('level_id')->nullable();
        });

        // Map IDs back to strings
        DB::statement('
            UPDATE courses
            SET category_id = (
                SELECT name FROM course_categories WHERE course_categories.id = courses.category_id
            )
        ');

        DB::statement('
            UPDATE courses
            SET level_id = (
                SELECT name FROM course_levels WHERE course_levels.id = courses.level_id
            )
        ');

        // Drop ID columns
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'level_id']);
        });
    }
};
