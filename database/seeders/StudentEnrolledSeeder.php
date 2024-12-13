<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\StudentEnrolled;

class StudentEnrolledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::take(5)->get(); // Example: first 5 users
        $courses = Course::take(3)->get(); // Example: first 3 courses

        foreach ($users as $user) {
            foreach ($courses as $course) {
                StudentEnrolled::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'is_completed' => false,
                    'completed_at' => null,
                ]);
            }
        }
    }
}
