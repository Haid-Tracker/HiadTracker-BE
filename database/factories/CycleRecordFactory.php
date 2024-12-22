<?php

namespace Database\Factories;

use App\Models\CycleRecord;
use App\Models\Symptom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CycleRecordFactory extends Factory
{
    protected $model = CycleRecord::class;

    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('-6 months', 'now');
        $end_date = clone $start_date;
        date_add($end_date, date_interval_create_from_date_string('5 days'));

        $durationCycle = rand(4, 7);

        $predicted_date = $this->calculatePredictedDateRange(
            $end_date->format('Y-m-d'),
            $durationCycle
        );

        $moods = ['happy', 'sad', 'tired', 'neutral'];

        return [
            'id' => fake()->uuid(),
            'user_id' => User::factory(),
            'start_date' => $start_date->format('Y-m-d H:i:s'),
            'end_date' => $end_date->format('Y-m-d H:i:s'),
            'predicted_date' => $predicted_date,
            'blood_volume' => fake()->randomElement(['normal', 'heavy']),
            'mood' => fake()->randomElement($moods),
            'medication' => fake()->boolean(),
            'cycle_regularity' => fake()->boolean(),
            'notes' => fake()->text(200),
        ];
    }

    private function calculatePredictedDateRange($endDate, $durationCycle): string
    {
        $minPredictedDate = Carbon::parse($endDate)->addDays(21 - $durationCycle);
        $maxPredictedDate = Carbon::parse($endDate)->addDays(35 - $durationCycle);

        $startPredict = $minPredictedDate->translatedFormat('d F Y');
        $endPredict = $maxPredictedDate->translatedFormat('d F Y');

        return "Prediksi siklus menstruasi Anda berikutnya antara tanggal {$startPredict} hingga {$endPredict}";
    }
}
