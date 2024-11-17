<?php

namespace Database\Factories;

use App\Models\CycleRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CycleRecordFactory extends Factory
{
    protected $model = CycleRecord::class;

    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('-6 months', 'now');
        $end_date = clone $start_date;
        date_add($end_date, date_interval_create_from_date_string('5 days'));

        $predicted_date = clone $start_date;
        date_add($predicted_date, date_interval_create_from_date_string('28 days'));

        $symptoms = [
            'headache' => fake()->boolean(),
            'cramps' => fake()->boolean(),
            'backPain' => fake()->boolean(),
            'nausea' => fake()->boolean(),
            'fatigue' => fake()->boolean(),
            'bloating' => fake()->boolean(),
        ];

        $moods = ['happy', 'sad', 'irritable', 'anxious', 'neutral', 'energetic'];

        return [
            'id' => fake()->uuid(),
            'user_id' => User::factory(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'predicted_date' => $predicted_date,
            'blood_volume' => fake()->randomElement(['light', 'medium', 'heavy']),
            'symptoms' => $symptoms,
            'mood' => fake()->randomElement($moods),
            'medication' => fake()->boolean(),
            'notes' => fake()->optional()->text(200),
        ];
    }
}
