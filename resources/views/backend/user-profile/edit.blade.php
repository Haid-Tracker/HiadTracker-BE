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
                    <li class="breadcrumb-item"><a href="{{ route('admin.user-profiles.index') }}">User Profiles</a></li>
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
            <form action="{{ route('admin.user-profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
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
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" class="form-control" name="photo" id="imageUpload" accept=".png, .jpg, .jpeg, .gif">
                                <label for="imageUpload"><i class="fas fa-pen"></i></label>
                            </div>

                            <div class="avatar-preview">
                                <div id="imagePreview"
                                     style="background-image: url('{{ $profile->photo ? asset('storage/assets/images/profile/' . $profile->photo) : '' }}');
                                            max-width: 200px; height: 200px; background-size: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.user-profiles.index') }}" class="btn btn-default float-right">Cancel</a>
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

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imageUpload").change(function() {
    readURL(this);
});
</script>
@endsection
