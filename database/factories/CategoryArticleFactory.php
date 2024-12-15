<?php

namespace Database\Factories;

use App\Models\CategoryArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryArticleFactory extends Factory
{
    protected $model = CategoryArticle::class;

    public function definition(): array
    {
        $categories = [
            'headache', 'cramps', 'backPain', 'nausea',
            'fatigue', 'bloating', 'normal', 'abnormal',
            'irregular', 'general', 'blood heavy', 'duration cycle',
            'length cycle', 'happy', 'sad', 'neutral', 'tired'
        ];

        return [
            'id' => fake()->uuid(),
            'name' => fake()->unique()->randomElement($categories),
        ];
    }
}
