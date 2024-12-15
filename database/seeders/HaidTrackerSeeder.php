<?php

namespace Database\Seeders;

use App\Models\CategorieArticle;
use App\Models\User;
use App\Models\Profile;
use App\Models\CycleRecord;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\Feedback;
use App\Models\Symptom;
use Illuminate\Database\Seeder;

class HaidTrackerSeeder extends Seeder
{
    public function run(): void
    {
        $symptomNames = ['headache', 'cramps', 'backPain', 'nausea', 'fatigue', 'bloating'];
        foreach ($symptomNames as $name) {
            Symptom::firstOrCreate(['name' => $name]);
        }

        Article::factory()->count(20)->create();
        $categories = [
            'headache', 'cramps', 'backPain', 'nausea',
            'fatigue', 'bloating', 'normal', 'abnormal',
            'irregular', 'general', 'blood heavy', 'duration cycle',
            'length cycle', 'happy', 'sad', 'neutral', 'tired',
        ];

        foreach ($categories as $category) {
            CategoryArticle::create([
                'name' => $category
            ]);
        }

        Article::all()->each(function ($article) {
            $categories = CategoryArticle::inRandomOrder()
                ->take(rand(1, 3))
                ->get();
            $article->categories()->attach($categories);
        });

        $users = User::role('user')->get();

        foreach ($users as $user) {
            $profile = Profile::factory()->create([
                'user_id' => $user->id,
                'photo' => 'assets/images/profile/profile.png',
            ]);

            $cycleRecords = CycleRecord::factory()
                ->count(6)
                ->create([
                    'user_id' => $user->id
                ]);

            foreach ($cycleRecords as $record) {
                $symptoms = Symptom::all();

                $selectedSymptoms = $symptoms->random(rand(1, 5))->pluck('id');

                $record->symptoms()->attach($selectedSymptoms);

                Feedback::factory()->create([
                    'cycle_record_id' => $record->id,
                    'status' => $this->determinePeriodStatus($record),
                    'feedback' => $this->generateFeedback($record)
                ]);
            }
        }
    }

    /**
     * Tentukan apakah periode normal atau tidak normal berdasarkan berbagai faktor
     */
    private function determinePeriodStatus($record)
    {
        $duration = date_diff(date_create($record->start_date), date_create($record->end_date))->days;

        if ($duration < 3 || $duration > 7) {
            return 'abnormal';
        }

        return 'normal';
    }

    /**
     * Hasilkan umpan balik yang sesuai berdasarkan status periode
     */
    private function generateFeedback($record)
    {
        $duration = date_diff(date_create($record->start_date), date_create($record->end_date))->days;

        if ($duration < 3) {
            return "Durasi periode Anda lebih pendek dari biasanya. Ini mungkin disebabkan oleh stres, perubahan berat badan, atau fluktuasi hormon. Pertimbangkan untuk berkonsultasi dengan penyedia layanan kesehatan jika hal ini berlanjut.";
        }

        if ($duration > 7) {
            return "Durasi periode Anda lebih lama dari biasanya. Meskipun ini dapat terjadi sesekali, jika berlanjut selama beberapa siklus, kami menyarankan Anda untuk berkonsultasi dengan penyedia layanan kesehatan.";
        }

        return "Periode Anda tampaknya berada dalam kisaran normal. Terus melacak untuk menjaga kesadaran akan kesehatan menstruasi Anda!";
    }
}
