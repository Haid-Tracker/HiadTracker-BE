<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    public function run(): void
    {
        $symptomNames = ['painful', 'cramps', 'nausea'];

        foreach ($symptomNames as $name) {
            Symptom::create([
                'id' => fake()->uuid(),
                'name' => $name,
            ]);
        }
    }
}
