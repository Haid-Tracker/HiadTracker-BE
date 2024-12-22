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
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

class CycleRecordController extends Controller
{
    public function index()
    {
        $datas = CycleRecord::where('user_id', Auth::id())
            ->with(['feedback'])
            ->latest()
            ->get();

        if ($datas->isEmpty()) {
            return redirect()->route('cycle-record.create');
        }

        $datas->map(function ($cycleRecord) {
            $cycleRecord->durationCycle = Carbon::parse($cycleRecord->end_date)
                ->diffInDays(Carbon::parse($cycleRecord->start_date)) + 1;
        });

        $chunkedDatas = $datas->chunk(3);
        $initialDatas = $chunkedDatas->first();
        $remainingDatas = $chunkedDatas->slice(1)->collapse();

        return view('frontend.cycle-records.index', compact('initialDatas', 'remainingDatas'));
    }

    public function create()
    {
        $symptoms = Symptom::all();
        $prediction = $this->getPredictionDates();
        $lastRecord = CycleRecord::where('user_id', Auth::id())
        ->with('articles')
        ->latest('start_date')
        ->first();
        $article = $lastRecord ? $lastRecord->articles->first() : null;

        return view('frontend.cycle-records.create', compact('symptoms', 'prediction', 'article'));
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

        return redirect()->route('cycle-record.create')
            ->with('success', 'Catatan siklus berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = CycleRecord::with(['symptoms', 'feedback'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $durationCycle = Carbon::parse($data->end_date)->diffInDays(Carbon::parse($data->start_date)) + 1;

        return view('frontend.cycle-records.show', compact('data', 'durationCycle'));
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
              return 'Siklus menstruasi Anda NORMAL. Tetap pertahankan dan selalu jaga kesehatan dengan makan teratur, olahraga secara rutin, dan memperhatikan kebersihan diri. Jangan lupa untuk terus mencatat siklus menstruasi Anda secara teratur.';
          }

          $feedback = "Siklus menstruasi Anda ABNORMAL karena:\n";
          foreach ($reasons as $reason) {
              $feedback .= "- {$reason}\n";
          }
          $feedback .= "\nSilakan baca artikel rekomendasi berikut untuk informasi lebih lanjut dan konsultasikan dengan dokter jika diperlukan.";

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

     private function getPredictionDates()
    {
        // Ambil record terakhir user
        $lastRecord = CycleRecord::where('user_id', Auth::id())
            ->with('feedback')
            ->latest('start_date')
            ->first();

        if (!$lastRecord) {
            return [
                'dates' => null,
                'month_year' => null,
                'feedback' => null,
            ];
        }

        $durationCycle = Carbon::parse($lastRecord->end_date)
            ->diffInDays(Carbon::parse($lastRecord->start_date)) + 1;

        $previousCycle = CycleRecord::where('user_id', Auth::id())
            ->where('id', '!=', $lastRecord->id)
            ->orderBy('start_date', 'desc')
            ->first();

        $lengthCycle = $previousCycle ?
            Carbon::parse($lastRecord->start_date)->diffInDays(Carbon::parse($previousCycle->start_date))
            : null;

        // Tentukan status normal dan dapatkan alasan jika abnormal
        $isNormal = $this->determineCycleStatus(
            $lengthCycle,
            $durationCycle,
            $lastRecord->blood_volume,
            $lastRecord->cycle_regularity
        );

        $abnormalityReasons = $this->getAbnormalityReasons(
            $lengthCycle,
            $durationCycle,
            $lastRecord->blood_volume,
            $lastRecord->cycle_regularity
        );

        // Generate pesan feedback
        $feedbackMessage = $this->generateFeedbackMessage($isNormal, $abnormalityReasons);

        if ($lengthCycle) {
            $minPredictedDate = Carbon::parse($lastRecord->start_date)->addDays(21);
            $maxPredictedDate = Carbon::parse($lastRecord->start_date)->addDays(35);
        } else {
            $minPredictedDate = Carbon::parse($lastRecord->end_date)->addDays(21 - $durationCycle);
            $maxPredictedDate = Carbon::parse($lastRecord->end_date)->addDays(35 - $durationCycle);
        }

        return [
            'dates' => $minPredictedDate->format('d').'-'.$maxPredictedDate->format('d'),
            'month_year' => $maxPredictedDate->format('F, Y'),
            'feedback' => $feedbackMessage,  // Gunakan pesan feedback yang baru digenerate
        ];
    }

    public function generateShowPdf($id)
    {
        $data = CycleRecord::with(['symptoms', 'feedback'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        $durationCycle = Carbon::parse($data->end_date)->diffInDays(Carbon::parse($data->start_date)) + 1;

        $view = View::make('frontend.cycle-records.pdf.show', compact('data', 'durationCycle'))->render();

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf->setOptions($options);

        $dompdf->loadHtml($view);

        $dompdf->render();

        return $dompdf->stream("cycle_record_{$data->start_date}.pdf", ["Attachment" => false]);
    }

    public function generateIndexPdf()
    {
        $datas = CycleRecord::where('user_id', Auth::id())
            ->with(['feedback', 'symptoms'])
            ->latest()
            ->get();

        $datas->map(function($cycleRecord) {
            $cycleRecord->durationCycle = Carbon::parse($cycleRecord->end_date)
                ->diffInDays(Carbon::parse($cycleRecord->start_date)) + 1;
        });

        $view = View::make('frontend.cycle-records.pdf.index', compact('datas'))->render();

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);

        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream("all_cycle_records.pdf", ["Attachment" => false]);
    }
}
