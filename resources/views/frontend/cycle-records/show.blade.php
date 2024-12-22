@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DetailNotes/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DetailNotes/responsive.css') }}" />
@endsection

@section('content')
<div class="container py-4">
    <div class="card" id="service">
        <div class="card-header">
            <h3>Detail Catatan Siklus</h3>
        </div>
        <div class="card-body">
            <dl class="details">
                <div class="row">
                    <dt class="col-sm-4">Tanggal Mulai</dt>
                    <dd class="col-sm-8">{{ Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Tanggal Selesai</dt>
                    <dd class="col-sm-8">{{ Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Durasi Siklus</dt>
                    <dd class="col-sm-8">{{ $durationCycle }} hari</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Volume Darah</dt>
                    <dd class="col-sm-8">{{ ucfirst($data->blood_volume) }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Suasana Hati</dt>
                    <dd class="col-sm-8">{{ ucfirst($data->mood) }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Siklus Teratur</dt>
                    <dd class="col-sm-8">{{ $data->cycle_regularity ? 'Ya' : 'Tidak' }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Menggunakan Obat</dt>
                    <dd class="col-sm-8">{{ $data->medication ? 'Ya' : 'Tidak' }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Gejalaaaa</dt>
                    <dd class="col-sm-8">
                        @if($data->symptoms->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($data->symptoms as $symptom)
                                    <li>{{ $symptom->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            Tidak ada gejala
                        @endif
                    </dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="{{ $data->feedback->status === 'normal' ? 'badge success' : 'badge warning' }}">
                            {{ $data->feedback->status === 'normal' ? 'Normal' : 'Abnormal' }}
                        </span>
                    </dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Feedback</dt>
                    <dd class="col-sm-8">{{ $data->feedback?->feedback }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Prediksi Siklus Berikutnya</dt>
                    <dd class="col-sm-8">{{ $data->predicted_date }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Catatan Tambahan</dt>
                    <dd class="col-sm-8">{{ $data->notes ?: 'Tidak ada catatan' }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-4">Rekomendasi Artikel</dt>
                    <dd class="col-sm-8">
                        @foreach($data->articles as $index => $article)
                            <a href="{{ route('article.show', $article->id) }}">
                                {{ $index + 1 }}. {{ $article->title }} [
                                @foreach($article->categories as $category)
                                    {{ $category->name }}
                                    @if(!$loop->last), @endif
                                @endforeach
                                ]
                            </a><br>
                        @endforeach
                    </dd>
                </div>
            </dl>

            <div class="button-container d-flex justify-content-start mt-3">
                <!-- Download Button -->

                {{-- <a href="{{ route('cycle-record.pdf', $data->id) }}" class="btn btn-primary" id="btn-download" download="catatan_siklus_{{ $data->start_date }}.pdf"> --}}
                <a href="{{ route('cycle-record.pdf', $data->id) }}" class="btn btn-primary" id="btn-download" target="blank">
                    Unduh Catatan
                </a>

                <!-- Kembali Button -->
                <button type="button" class="btn btn-secondary ms-3" onclick="window.location.href='{{ route('cycle-record.index') }}'">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection
