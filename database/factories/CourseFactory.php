<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\CourseLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'title' => $this->faker->sentence(),
        'description' => $this->faker->paragraph(),
        'profile_image' => $this->faker->imageUrl(640, 480, 'education', true),
        'price' => $this->faker->randomFloat(2, 10, 200),
        'level_id' => CourseLevel::factory(),
        'category_id' => CourseCategory::factory(),
        'duration' => $this->faker->numberBetween(30, 300),
        'user_id' => \App\Models\User::factory(),
        'status' => $this->faker->randomElement([0,1]),
    ];
}

}
