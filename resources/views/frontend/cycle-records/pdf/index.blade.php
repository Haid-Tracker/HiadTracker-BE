<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Cycle Records</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header-notes {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-notes h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .tracker {
            background-color: #e8e8f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
        }

        .tracker h3 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }

        .selected-dates-container {
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
        }

        .selected-dates-container label {
            font-weight: 500;
            color: #555;
        }

        .selected-dates-container p {
            margin-top: 15px;
            /* Menambahkan margin atas pada tanggal */
            font-size: 16px;
            color: #333;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            margin-top: 5px;
        }

        .bg-success {
            background-color: #28a745;
            color: #fff;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #000;
        }

        .notes {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .notes h4 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
            color: #333;
        }

        .mood-button span {
            display: inline-block;
            background-color: #f0c452;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 14px;
            color: #fff;
        }

        .symptom-button button {
            padding: 8px 15px;
            border-radius: 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            color: white;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }

        .symptom-painful {
            background-color: #999999;
        }

        .symptom-cramps {
            background-color: #3C3C43;
        }

        .symptom-nausea {
            background-color: #3E9C6E;
        }

        textarea {
            width: 100%;
            min-height: 80px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f9f9f9;
            resize: none;
            color: #333;
        }

        hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-notes">
            <h2>Catatan Siklus Anda</h2>
        </div>
        @foreach ($datas as $data)
        <div class="tracker">
            <h3>Kalender Siklus</h3>
            <div class="selected-dates-container">
                <label><strong>Tanggal Siklus</strong></label>
                <p>
                    {{ \Carbon\Carbon::parse($data->start_date)->locale('id')->isoFormat('D MMM YYYY') }} &ndash;
                    {{ \Carbon\Carbon::parse($data->end_date)->locale('id')->isoFormat('D MMM YYYY') }}
                </p>
                <p><strong>Status Siklus:</strong>
                    <span class="badge {{ $data->feedback?->status === 'normal' ? 'bg-success' : 'bg-warning' }}">
                        {{ $data->feedback?->status === 'normal' ? 'Normal' : 'Abnormal' }}
                    </span>
                </p>
            </div>
            <div class="notes">
                <h4>Mood</h4>
                <div class="mood-button">
                    @if ($data->mood === 'happy')
                        <span>😊 {{ ucfirst($data->mood) }}</span>
                    @elseif ($data->mood === 'neutral')
                        <span>😐 {{ ucfirst($data->mood) }}</span>
                    @else
                        <span>😞 {{ ucfirst($data->mood) }}</span>
                    @endif
                </div>
                <hr>
                <h4>Gejala</h4>
                <div class="symptom-button">
                    @if($data->symptoms->count() > 0)
                    @foreach($data->symptoms as $symptom)
                        <button type="button" class="symptom-{{ $symptom->name }}">
                            {{ ($symptom->name) }}
                        </button>
                    @endforeach
                    @else
                        <button type="button">Tidak Ada Gejala</button>
                    @endif
                </div>
                <hr>
                <h4>Catatan Lainnya:</h4>
                <textarea readonly>{{ $data->notes ?? 'Tidak ada catatan tambahan.' }}</textarea>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
