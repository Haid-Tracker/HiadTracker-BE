@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit User Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user-profiles.index') }}">User Profiles</a></li>
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
                    <h3 class="card-title">Edit Profile Information</h3>
                </div>
                <form action="{{route('user.cycle-record.update', $datas->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" step="0.01" class="form-control" name="startdate"
                                value="{{ old('startdate', $datas->start_date ? $datas->start_date->toDateString() : '') }}">
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" step="0.01" class="form-control" name="enddate"
                                value="{{ old('enddate', $datas->end_date ? $datas->end_date->toDateString() : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Predicted Date</label>
                            <input type="date" class="form-control" name="predicteddate"
                                value="{{ old('predicteddate', $datas->predicted_date ? $datas->predicted_date->toDateString() : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Blood Volume</label>
                            <select class="form-control" name="bloodvolume">
                                <option value="light" {{ old('bloodvolume', $datas->blood_volume) == 'light' ? 'selected' : '' }}>Light</option>
                                <option value="medium" {{ old('bloodvolume', $datas->blood_volume) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="heavy" {{ old('bloodvolume', $datas->blood_volume) == 'heavy' ? 'selected' : '' }}>Heavy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Mood</label>
                            <input type="text" class="form-control" name="mood"
                                value="{{ old('mood', $datas->mood) }}">
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('user.cycle-record') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js-section')
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
