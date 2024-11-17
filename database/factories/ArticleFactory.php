<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'title' => fake()->sentence(),
            'hero_photo' => fake()->optional()->imageUrl(640, 480, 'health'),
            'content' => fake()->paragraphs(5, true),
            'author' => fake()->optional()->name() ?? 'Haid Tracker - Team',
        ];
    }
}
