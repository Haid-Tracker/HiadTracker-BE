<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\CycleRecord;
use App\Models\Article;
use App\Models\Feedback;
use Illuminate\Database\Seeder;

class HaidTrackerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample articles
        Article::factory()->count(10)->create();

        $users = User::role('user')->get();

        foreach ($users as $user) {
            // Create profile for each user
            $profile = Profile::factory()->create([
                'user_id' => $user->id,
                'photo' => 'assets/images/profile/profile.png',
            ]);

            // Create multiple cycle records for each user
            $cycleRecords = CycleRecord::factory()
                ->count(6)
                ->create([
                    'user_id' => $user->id
                ]);

            // Create feedback for each cycle record
            foreach ($cycleRecords as $record) {
                Feedback::factory()->create([
                    'cycle_record_id' => $record->id,
                    'status' => $this->determinePeriodStatus($record),
                    'feedback' => $this->generateFeedback($record)
                ]);
            }
        }
    }

    /**
     * Determine if period is normal or abnormal based on various factors
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
     * Generate appropriate feedback based on period status
     */
    private function generateFeedback($record)
    {
        $duration = date_diff(date_create($record->start_date), date_create($record->end_date))->days;

        if ($duration < 3) {
            return "Your period duration is shorter than usual. This might be due to stress, weight changes, or hormonal fluctuations. Consider consulting with a healthcare provider if this persists.";
        }

        if ($duration > 7) {
            return "Your period duration is longer than usual. While this can happen occasionally, if it continues for several cycles, we recommend consulting with a healthcare provider.";
        }

        return "Your period appears to be within normal range. Keep tracking to maintain awareness of your menstrual health!";
    }
}
