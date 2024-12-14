@extends('frontend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <!-- Update Profile Information Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Profile Information</h3>
                </div>
                <div class="card-body">
                    @include('frontend.profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Update Password Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <div class="card-body">
                    @include('frontend.profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Delete User Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Delete Account</h3>
                </div>
                <div class="card-body">
                    @include('frontend.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
