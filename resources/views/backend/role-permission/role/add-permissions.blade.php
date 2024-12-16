@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Role Permissions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/roles') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('status') }}
        </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Manage Permissions for Role: {{ $role->name }}</h3>
            </div>
            <form action="{{ url('admin/roles/'.$role->id.'/give-permissions') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @error('permission')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="row">
                        @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox"
                                           id="permission{{ $permission->id }}"
                                           name="permission[]"
                                           value="{{ $permission->name }}"
                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    <label for="permission{{ $permission->id }}" class="custom-control-label">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Permissions</button>
                    <a href="{{ url('admin/roles') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
