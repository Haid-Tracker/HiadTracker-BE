<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'user_id' => User::factory(),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'weight' => fake()->randomFloat(2, 40, 100),
            'height' => fake()->randomFloat(2, 140, 180),
            'photo' => null,
        ];
    }
}
