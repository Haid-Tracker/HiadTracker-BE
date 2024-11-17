<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'cycle_record_id' => null, // Will be set in seeder
            'status' => fake()->randomElement(['normal', 'abnormal']),
            'feedback' => fake()->paragraph(),
        ];
    }
}
