<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentikasi - HaidTracker</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/img/LandingPage/noto_drop-of-blood.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/Autentikasi/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/Autentikasi/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/alert.css') }}">
    <!-- CSS CDN Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="navbartop"></div>
    @yield('content')

    @yield('js-section')

<script src="{{ asset('assets/frontend/script/alert.js') }}"></script>
</body>

</html>
