<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    public function run(): void
    {
        $symptomNames = ['headache', 'cramps', 'backPain', 'nausea', 'fatigue', 'bloating'];

        foreach ($symptomNames as $name) {
            Symptom::create([
                'id' => fake()->uuid(),
                'name' => $name,
            ]);
        }
    }
}
