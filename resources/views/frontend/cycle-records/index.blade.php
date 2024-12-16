@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Catatan Siklus Menstruasi</h2>
        <a href="{{ route('cycle-record.create') }}" class="btn btn-primary">Tambah Catatan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($datas as $data)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Catatan Siklus Menstruasi</h5><br>
                        <p><strong>Tanggal Mulai:</strong> {{ Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</p>
                        <p><strong>Tanggal Selesai:</strong> {{ Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</p>
                        <p><strong>Durasi:</strong> {{ $data->duration_cycle }} hari</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $data->feedback?->status === 'normal' ? 'success' : 'warning' }}">
                                {{ $data->feedback?->status === 'normal' ? 'Normal' : 'Abnormal' }}
                            </span>
                        </p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cycle-record.show', $data->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('cycle-record.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('cycle-record.destroy', $data->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada catatan siklus
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
