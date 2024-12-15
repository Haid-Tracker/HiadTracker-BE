<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CycleRecord;
use App\Models\Feedback;
use App\Models\Symptom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CycleRecordController extends Controller
{
    public function index()
    {
        $datas = CycleRecord::where('user_id', Auth::id())
            ->latest()
            ->with(['feedback'])
            ->get();

        return view('frontend.cycle-records.index', compact('datas'));
    }

    public function create()
    {
        $symptoms = Symptom::all();
        return view('frontend.cycle-records.create', compact('symptoms'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'blood_volume' => 'required',
            'mood' => 'required|in:happy,sad,neutral,tired',
            'cycle_regularity' => 'nullable|boolean',
            'medication' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'symptoms' => 'array|exists:symptoms,id',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validatedData['user_id'] = Auth::id();

        $durationCycle = Carbon::parse($validatedData['end_date'])->diffInDays(Carbon::parse($validatedData['start_date'])) + 1;

        $previousCycle = CycleRecord::where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->first();

        $lengthCycle = $previousCycle ?
            Carbon::parse($validatedData['start_date'])->diffInDays(Carbon::parse($previousCycle->start_date))
            : null;

        $predictedDateRange = $this->calculatePredictedDateRange(
            $validatedData['start_date'],
            $validatedData['end_date'],
            $lengthCycle,
            $durationCycle
        );

        $isNormal = $this->determineCycleStatus(
            $lengthCycle,
            $durationCycle,
            $validatedData['blood_volume'],
            $validatedData['cycle_regularity']
        );

        $validatedData['medication'] = $request->has('medication') ? $validatedData['medication'] : 0;
        $validatedData['cycle_regularity'] = $request->has('cycle_regularity') ? $validatedData['cycle_regularity'] : 0;

        $cycleRecord = CycleRecord::create([
            'user_id' => Auth::id(),
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'predicted_date' => $predictedDateRange,
            'blood_volume' => $validatedData['blood_volume'],
            'mood' => $validatedData['mood'],
            'cycle_regularity' => $validatedData['cycle_regularity'],
            'medication' => $validatedData['medication'],
            'notes' => $validatedData['notes'],
            'duration_cycle' => $durationCycle,
            'length_cycle' => $lengthCycle
        ]);

        if (!empty($validatedData['symptoms'])) {
            $cycleRecord->symptoms()->attach($validatedData['symptoms']);
        }

        Feedback::create([
            'cycle_record_id' => $cycleRecord->id,
            'status' => $isNormal ? 'normal' : 'abnormal',
            'feedback' => $this->generateFeedbackMessage($isNormal, $this->getAbnormalityReasons(
                $lengthCycle,
                $durationCycle,
                $validatedData['blood_volume'],
                $validatedData['cycle_regularity']
            ))
        ]);

        $categories = $this->getRecommendedCategories(
            $cycleRecord,
            $validatedData,
        );

        foreach ($categories as $category) {
            $articles = Article::whereHas('categories', function($query) use ($category) {
                $query->where('name', $category);
            })->get();

            foreach ($articles as $article) {
                $cycleRecord->articles()->syncWithoutDetaching([$article->id]);
            }
        }

        return redirect()->route('cycle-record.index')
            ->with('success', 'Catatan siklus berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $data = CycleRecord::with(['symptoms', 'feedback'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.cycle-records.show', compact('data'));
    }

    public function edit($id)
    {
        $cycleRecord = CycleRecord::where('user_id', Auth::id())->findOrFail($id);
        $symptoms = Symptom::all();
        return view('frontend.cycle-records.edit', compact('cycleRecord', 'symptoms'));
    }

    public function update(Request $request, $id)
    {
        $cycleRecord = CycleRecord::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'blood_volume' => 'required',
            'mood' => 'required|in:happy,sad,neutral,tired',
            'cycle_regularity' => 'nullable|boolean',
            'medication' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'symptoms' => 'array|exists:symptoms,id'
        ]);

        $durationCycle = Carbon::parse($validatedData['end_date'])->diffInDays(Carbon::parse($validatedData['start_date'])) + 1;

        $previousCycle = CycleRecord::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->orderBy('start_date', 'desc')
            ->first();

        $lengthCycle = $previousCycle ?
            Carbon::parse($validatedData['start_date'])->diffInDays(Carbon::parse($previousCycle->start_date))
            : null;

        Log::debug('preve Cycle upt: ' . $previousCycle);

        $predictedDateRange = $this->calculatePredictedDateRange(
            $validatedData['start_date'],
            $validatedData['end_date'],
            $lengthCycle,
            $durationCycle
        );

        $isNormal = $this->determineCycleStatus(
            $lengthCycle,
            $durationCycle,
            $validatedData['blood_volume'],
            $validatedData['cycle_regularity']
        );

        $validatedData['medication'] = $request->has('medication') ? $validatedData['medication'] : 0;
        $validatedData['cycle_regularity'] = $request->has('cycle_regularity') ? $validatedData['cycle_regularity'] : 0;

        $cycleRecord->update([
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'predicted_date' => $predictedDateRange,
            'blood_volume' => $validatedData['blood_volume'],
            'mood' => $validatedData['mood'],
            'cycle_regularity' => $validatedData['cycle_regularity'],
            'medication' => $validatedData['medication'],
            'notes' => $validatedData['notes'],
            'duration_cycle' => $durationCycle,
            'length_cycle' => $lengthCycle
        ]);

        if (isset($validatedData['symptoms'])) {
            $cycleRecord->symptoms()->sync($validatedData['symptoms']);
        }

        // Update atau buat feedback baru
        $feedback = Feedback::where('cycle_record_id', $cycleRecord->id)->first();
        $abnormalityReasons = $this->getAbnormalityReasons(
            $lengthCycle,
            $durationCycle,
            $validatedData['blood_volume'],
            $validatedData['cycle_regularity']
        );

        if ($feedback) {
            $feedback->update([
                'status' => $isNormal ? 'normal' : 'abnormal',
                'feedback' => $this->generateFeedbackMessage($isNormal, $abnormalityReasons)
            ]);
        } else {
            Feedback::create([
                'cycle_record_id' => $cycleRecord->id,
                'status' => $isNormal ? 'normal' : 'abnormal',
                'feedback' => $this->generateFeedbackMessage($isNormal, $abnormalityReasons)
            ]);
        }

        $categories = $this->getRecommendedCategories(
            $cycleRecord,
            $validatedData,
        );

        $cycleRecord->articles()->detach();

        foreach ($categories as $category) {
            $articles = Article::whereHas('categories', function($query) use ($category) {
                $query->where('name', $category);
            })->get();

            foreach ($articles as $article) {
                $cycleRecord->articles()->syncWithoutDetaching([$article->id]);
            }
        }

        return redirect()->route('cycle-record.index')
            ->with('success', 'Catatan siklus berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $data = CycleRecord::where('user_id', Auth::id())->findOrFail($id);
        $data->delete();

        return redirect()->route('cycle-record.index')
            ->with('success', 'Catatan siklus berhasil dihapus.');
    }

    // Fungsi helper yang sama seperti controller sebelumnya
    private function calculatePredictedDateRange($startDate, $endDate, $lengthCycle, $durationCycle): string
     {
         if ($lengthCycle) {
             $minPredictedDate = Carbon::parse($startDate)->addDays(21);
             $maxPredictedDate = Carbon::parse($startDate)->addDays(35);
         } else {
             $minPredictedDate = Carbon::parse($endDate)->addDays(21 - $durationCycle);
             $maxPredictedDate = Carbon::parse($endDate)->addDays(35 - $durationCycle);
         }

         $startPredict = $minPredictedDate->translatedFormat('d F Y');
         $endPredict = $maxPredictedDate->translatedFormat('d F Y');

         return "Prediksi siklus menstruasi Anda berikutnya antara tanggal {$startPredict} hingga {$endPredict}";
     }
     private function determineCycleStatus($lengthCycle, $durationCycle, $bloodVolume, $cycleRegularity)
     {
         if ($lengthCycle === null) {
             return (
                 $durationCycle >= 4 &&
                 $durationCycle <= 7 &&
                 $bloodVolume === 'normal' &&
                 $cycleRegularity == 1
             );
         }

         return (
             $lengthCycle >= 21 &&
             $lengthCycle <= 35 &&
             $durationCycle >= 4 &&
             $durationCycle <= 7 &&
             $bloodVolume === 'normal' &&
             $cycleRegularity == 1
         );
     }

     /**
      * Mengidentifikasi alasan ketidaknormalan siklus
      */
     private function getAbnormalityReasons($lengthCycle, $durationCycle, $bloodVolume, $cycleRegularity)
     {
         $reasons = [];

         if ($lengthCycle !== null) {
             if ($lengthCycle < 21 || $lengthCycle > 35) {
                 $reasons[] = "Panjang siklus ({$lengthCycle} hari) di luar rentang normal (21-35 hari)";
             }
         }

         if ($durationCycle < 4 || $durationCycle > 7) {
             $reasons[] = "Durasi menstruasi ({$durationCycle} hari) di luar rentang normal (4-7 hari)";
         }

         if ($bloodVolume !== 'normal') {
             $reasons[] = "Volume darah tidak normal, pergantian pembalut melebihi normal (max 1 kali per jam)";
         }

         if ($cycleRegularity == 0) {
             $reasons[] = "Siklus tidak teratur";
         }

         return $reasons;
     }

     /**
      * Menghasilkan pesan feedback berdasarkan status dan alasan abnormal
      */
     private function generateFeedbackMessage($isNormal, $reasons = [])
     {
         if ($isNormal) {
             return 'Siklus menstruasi Anda NORMAL.';
         }

         $feedback = "Siklus menstruasi Anda ABNORMAL karena:\n";
         foreach ($reasons as $reason) {
             $feedback .= "- {$reason}\n";
         }
         $feedback .= "\nSilakan baca artikel rekomendasi berikut untuk informasi lebih lanjut.";

         return $feedback;
     }

     private function getRecommendedCategories($cycleRecord, $validatedData)
     {
        $categories = [];

        $durationCycle = Carbon::parse($validatedData['end_date'])->diffInDays(Carbon::parse($validatedData['start_date'])) + 1;

        // Mengambil data siklus sebelumnya dengan mengecualikan record saat ini
        $previousCycle = CycleRecord::where('user_id', Auth::id())
            ->where('id', '!=', $cycleRecord->id)  // Mengecualikan record yang sedang diupdate
            ->where('start_date', '<', $validatedData['start_date']) // Memastikan hanya mengambil data yang lebih lama
            ->orderBy('start_date', 'desc')
            ->first();

        Log::debug('previous Cycle: ' . $previousCycle);

        $lengthCycle = $previousCycle ?
            Carbon::parse($validatedData['start_date'])->diffInDays(Carbon::parse($previousCycle->start_date))
            : null;

        Log::debug('length Cycle: ' . $lengthCycle);

         if ($cycleRecord->blood_volume == 'heavy') {
             $categories[] = 'blood heavy';
         }

         if ($cycleRecord->mood == 'sad') {
             $categories[] = 'sad';
         }
         if ($cycleRecord->mood == 'happy') {
             $categories[] = 'happy';
         }
         if ($cycleRecord->mood == 'tired') {
             $categories[] = 'tired';
         }
         if ($cycleRecord->mood == 'neutral') {
             $categories[] = 'neutral';
         }

         if ($cycleRecord->cycle_regularity == 0) {
             $categories[] = 'irregular';
         }

         foreach ($validatedData['symptoms'] ?? [] as $symptomId) {
             $symptom = Symptom::find($symptomId);
             if ($symptom) {
                 $categories[] = $symptom->name;
             }
         }

         $feedbackStatus = $validatedData['feedback_status'] ?? null;
         if ($feedbackStatus == 'abnormal') {
             $categories[] = 'abnormal';
         }

         if ($lengthCycle !== null) {
             if ($lengthCycle < 21 || $lengthCycle > 35) {
                 $categories[] = 'length cycle';
             }
         }

         if ($durationCycle < 4 || $durationCycle > 7) {
             $categories[] = 'duration cycle';
         }

         return array_unique($categories);
     }
}
