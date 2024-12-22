<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Cycle Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
        }
        h1 {
            text-align: center;
        }
        .cycle-details {
            margin-top: 20px;
            background-color: #f4f4f4;
            padding: 1.5em;
            border-radius: 16px;
        }
        table {
            background: white;
            padding: 1em;
            border-radius: 16px;
        }
        th, td {
            padding: 16px;
            background: white;
            border: none !important;
            margin: none;
        }
        th {
            text-align: left !important;
            border-bottom: 2px solid #f4f4f4 !important;
        }
        td {
            text-align: right !important;
            border-bottom: 2px solid #f4f4f4 !important;
        }
        td .feedback-normal,
        td .feedback-abnormal
        {
            text-transform: uppercase;
        }
        .feedback-normal {
            background-color: #e6f7e6;
            color: #28a745;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding:  10px;
            display: inline-block;
        }
        .feedback-abnormal {
            background-color: #f8d7da;
            color: #dc3545;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <h1>Catatan Siklus Haid - {{ \Carbon\Carbon::parse($data->start_date)->format('F Y') }}</h1>

    <div class="cycle-details">
        <h3>Details :</h3>
        <table width="100%">
            <tr>
                <th>Start Date</th>
                <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ \Carbon\Carbon::parse($data->end_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Duration</th>
                <td>{{ $durationCycle }} days</td>
            </tr>
            <tr>
                <th>Blood Volume</th>
                <td>{{ $data->blood_volume }}</td>
            </tr>
            <tr>
                <th>Mood</th>
                <td>{{ ucfirst($data->mood) }}</td>
            </tr>
            <tr>
                <th>Cycle Regularity</th>
                <td>{{ $data->cycle_regularity ? 'Regular' : 'Irregular' }}</td>
            </tr>
            <tr>
                <th>Medication</th>
                <td>{{ $data->medication ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="{{ $data->feedback->status === 'normal' ? 'feedback-normal' : 'feedback-abnormal' }}">
                        {{ $data->feedback->status }}
                    </span>
                </td>
            </tr>
        </table>

        <h3>Notes:</h3>
        <p>{{ $data->notes }}</p>

        <h3>Symptoms:</h3>
        <p>
            @foreach ($data->symptoms as $key => $symptom)
                <span>{{ $symptom->name }}</span>@if (!$loop->last),@endif
            @endforeach
        </p>
        <h3>Feedback:</h3>
        <p class="{{ $data->feedback->status === 'normal' ? 'feedback-normal' : 'feedback-abnormal' }}">
            {{ $data->feedback->feedback }}
        </p>
    </div>

</body>
</html>
