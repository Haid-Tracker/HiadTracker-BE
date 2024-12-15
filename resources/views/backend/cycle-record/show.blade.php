@extends('backend.layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Cycle Record Details</h3>
            </div>
            <div class="card-body">
                <h4>User: {{ $data->user->name }}</h4>
                <p>Start Date: {{ $data->start_date }}</p>
                <p>End Date: {{ $data->end_date }}</p>
                <p>Predicted Date: {{ $data->predicted_date }}</p>
                <p>Blood Volume:
                    {{ $data->blood_volume }}
                </p>
                <p>Mood: {{ $data->mood }}</p>
                <p>Medication: {{ $data->medication ? 'Yes' : 'No' }}</p>
                <p>cycle Regularity : {{ $data->cycle_regularity ? 'Reguler' : 'Ireguler' }}</p>

                <p>Symptoms:
                    @if($data->symptoms && $data->symptoms->count() > 0)
                        {{ $data->symptoms->pluck('name')->implode(', ') }}
                    @else
                        No symptoms recorded
                    @endif
                </p>
                <p>Feedback Status: {{ $data->feedback?->status ?? 'N/A' }}</p>
                <p>Feedback : {{ $data->feedback->feedback }}</p>
                <p>Notes: {{ $data->notes }}</p>
                <p>Rekomendasi Article:</p>
                @foreach($data->articles as $index => $article)
                    <p>
                        {{ $index + 1 }}. {{ $article->title }} [
                        @foreach($article->categories as $category)
                            {{ $category->name }}
                            @if(!$loop->last), @endif
                        @endforeach
                        ]
                    </p>
                @endforeach



            </div>
        </div>
    </div>
</section>
@endsection
