<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseLevel>
 */
class CourseLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->randomLevel(),
        ];
    }

    private function randomLevel()
    {
        return $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']);
    }
}
