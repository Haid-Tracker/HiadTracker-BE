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
            <form action="{{ route('user-profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control select2" name="user_id" style="width: 100%;">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $profile->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                        <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date', $profile->birth_date) }}">
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" step="0.01" class="form-control" name="weight" value="{{ old('weight', $profile->weight) }}">
                    </div>
                    <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="number" step="0.01" class="form-control" name="height" value="{{ old('height', $profile->height) }}">
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        @if($profile->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/assets/images/profile/' . $profile->photo) }}"
                                     alt="Profile Photo"
                                     style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="photo">
                    </div>
                    <div class="form-group">
                        <label>Cycle Length (days)</label>
                        <input type="number" class="form-control" name="cycle_length" value="{{ old('cycle_length', $profile->cycle_length) }}">
                    </div>
                    <div class="form-group">
                        <label>Last Period Date</label>
                        <input type="date" class="form-control" name="last_period_date" value="{{ old('last_period_date', $profile->last_period_date) }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user-profiles.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('js-section')
<script>
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endsection
