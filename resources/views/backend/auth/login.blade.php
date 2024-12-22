<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

  <style>
    body{
        background: white !important;
    }
    .top {
        background-color: #6b0d0d;
        padding: 10px 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 9999;
    }
    button[type=submit] {
        background: #6b0d0d;
        border: none;
    }
    button[type=submit]:hover {
        background: #7a0e0e;
        border: none;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="top"></div>
<div class="login-box">
  <div class="login-logo d-flex justify-content-center mx-0">
    <a href="/admin/login"><b>Haid</b>Tracker</a>
    <img src="{{ asset('assets/frontend/img/LandingPage/noto_drop-of-blood.png') }}" alt="HaidTracker Logo" class="brand-image img-circle" style="opacity: .8">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login Admin</p>
      <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>

        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-block" style="color: #fff;">Sign In</button>
          </div>
        </div>
      </form>
      @if ($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
      @endif

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
