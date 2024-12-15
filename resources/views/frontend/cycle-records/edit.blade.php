@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Edit Catatan Siklus</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cycle-record.update', $cycleRecord->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start_date" name="start_date"
                                value="{{ old('start_date', $cycleRecord->start_date) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end_date" name="end_date"
                                value="{{ old('end_date', $cycleRecord->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="blood_volume" class="form-label">Volume Darah</label>
                            <select class="form-select @error('blood_volume') is-invalid @enderror"
                                id="blood_volume" name="blood_volume">
                                <option value="">Pilih Volume Darah</option>
                                <option value="normal" {{ old('blood_volume', $cycleRecord->blood_volume) == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="heavy" {{ old('blood_volume', $cycleRecord->blood_volume) == 'heavy' ? 'selected' : '' }}>Berat</option>
                            </select>
                            @error('blood_volume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mood" class="form-label">Suasana Hati</label>
                            <select class="form-select @error('mood') is-invalid @enderror"
                                id="mood" name="mood">
                                <option value="">Pilih Suasana Hati</option>
                                <option value="happy" {{ old('mood', $cycleRecord->mood) == 'happy' ? 'selected' : '' }}>Senang</option>
                                <option value="sad" {{ old('mood', $cycleRecord->mood) == 'sad' ? 'selected' : '' }}>Sedih</option>
                                <option value="neutral" {{ old('mood', $cycleRecord->mood) == 'neutral' ? 'selected' : '' }}>Netral</option>
                                <option value="tired" {{ old('mood', $cycleRecord->mood) == 'tired' ? 'selected' : '' }}>Lelah</option>
                            </select>
                            @error('mood')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('cycle_regularity') is-invalid @enderror"
                                    id="cycle_regularity" name="cycle_regularity" value="1"
                                    {{ old('cycle_regularity', $cycleRecord->cycle_regularity) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cycle_regularity">Siklus Teratur</label>
                            </div>
                            @error('cycle_regularity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('medication') is-invalid @enderror"
                                    id="medication" name="medication" value="1"
                                    {{ old('medication', $cycleRecord->medication) ? 'checked' : '' }}>
                                <label class="form-check-label" for="medication">Menggunakan Obat</label>
                            </div>
                            @error('medication')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gejala</label>
                            <div class="row">
                                @foreach($symptoms as $symptom)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                name="symptoms[]" value="{{ $symptom->id }}"
                                                {{ in_array($symptom->id, old('symptoms', $cycleRecord->symptoms->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $symptom->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="3">{{ old('notes', $cycleRecord->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Perbarui Catatan</button>
                            <a href="{{ route('cycle-record.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
