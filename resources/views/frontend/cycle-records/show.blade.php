@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Detail Catatan Siklus</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Tanggal Mulai</dt>
                        <dd class="col-sm-8">{{ Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</dd>

                        <dt class="col-sm-4">Tanggal Selesai</dt>
                        <dd class="col-sm-8">{{ Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</dd>

                        <dt class="col-sm-4">Durasi Siklus</dt>
                        <dd class="col-sm-8">{{ $data->duration_cycle }} hari</dd>

                        <dt class="col-sm-4">Volume Darah</dt>
                        <dd class="col-sm-8">{{ ucfirst($data->blood_volume) }}</dd>

                        <dt class="col-sm-4">Suasana Hati</dt>
                        <dd class="col-sm-8">{{ ucfirst($data->mood) }}</dd>

                        <dt class="col-sm-4">Siklus Teratur</dt>
                        <dd class="col-sm-8">{{ $data->cycle_regularity ? 'Ya' : 'Tidak' }}</dd>

                        <dt class="col-sm-4">Menggunakan Obat</dt>
                        <dd class="col-sm-8">{{ $data->medication ? 'Ya' : 'Tidak' }}</dd>

                        <dt class="col-sm-4">Gejala</dt>
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

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-{{ $data->feedback?->status === 'normal' ? 'success' : 'warning' }}">
                                {{ $data->feedback?->status === 'normal' ? 'Normal' : 'Abnormal' }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Feedback</dt>
                        <dd class="col-sm-8">{{ $data->feedback?->feedback }}</dd>

                        <dt class="col-sm-4">Prediksi Siklus Berikutnya</dt>
                        <dd class="col-sm-8">{{ $data->predicted_date }}</dd>

                        <dt class="col-sm-4">Catatan Tambahan</dt>
                        <dd class="col-sm-8">{{ $data->notes ?: 'Tidak ada catatan' }}</dd>

                        <dt class="col-sm-4">Rekomendasi Article :</dt>
                        @foreach($data->articles as $index => $article)
                        <a href="{{ route('article.show', $article->id) }}">
                        <dd class="col-sm-12">
                            {{ $index + 1 }}. {{ $article->title }} [
                            @foreach($article->categories as $category)
                                {{ $category->name }}
                                @if(!$loop->last), @endif
                            @endforeach
                            ]
                        </dd>
                        </a>
                        @endforeach
                    </dl>
                    <div class="d-grid gap-2">
                        <a href="{{ route('cycle-record.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('cycle-record.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
