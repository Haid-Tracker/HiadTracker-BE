@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Cycle Record</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cycle-record') }}">Cycle Records</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cycle Record Information</h3>
            </div>
            <form action="{{ route('admin.cycle-record.update', $cycleRecord->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- To specify the update method -->
                <div class="card-body">
                    <!-- User Selection -->
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" name="user_id">
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" @if($cycleRecord->user_id == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $cycleRecord->start_date) }}">
                            </div>
                        </div>
                        <!-- End Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $cycleRecord->end_date) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Blood Volume -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Volume</label>
                                <select class="form-control" name="blood_volume">
                                    <option value="normal" @if($cycleRecord->blood_volume == 'normal') selected @endif>Normal (≤1 pad/hour)</option>
                                    <option value="heavy" @if($cycleRecord->blood_volume == 'heavy') selected @endif>Heavy (>1 pad/hour)</option>
                                </select>
                            </div>
                        </div>
                        <!-- Cycle Regularity -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cycle Regularity</label>
                                <select class="form-control" name="cycle_regularity">
                                    <option value="1" @if($cycleRecord->cycle_regularity == 1) selected @endif>Regular</option>
                                    <option value="0" @if($cycleRecord->cycle_regularity == 0) selected @endif>Irregular</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Mood -->
                    <div class="form-group">
                        <label>Mood</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['happy', 'sad', 'neutral', 'tired'] as $mood)
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="mood" value="{{ $mood }}" id="mood_{{ $mood }}" @if($cycleRecord->mood == $mood) checked @endif>
                                    <label class="form-check-label" for="mood_{{ $mood }}">
                                        {{ ucfirst($mood) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Medication -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="medication" name="medication" value="1" @if($cycleRecord->medication) checked @endif>
                            <label for="medication" class="custom-control-label">Taking Medication</label>
                        </div>
                    </div>

                    <!-- Symptoms -->
                    <div class="form-group">
                        <label>Symptoms</label>
                        <div class="row">
                            @foreach($symptoms as $symptom)
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox"
                                               id="symptom_{{ $symptom->id }}"
                                               name="symptoms[]"
                                               value="{{ $symptom->id }}" @if(in_array($symptom->id, $cycleRecord->symptoms->pluck('id')->toArray())) checked @endif>
                                        <label class="custom-control-label" for="symptom_{{ $symptom->id }}">
                                            {{ $symptom->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Enter notes">{{ old('notes', $cycleRecord->notes) }}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('admin.cycle-record') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
