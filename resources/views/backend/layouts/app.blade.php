@include('backend.layouts.shared.header')
@include('backend.layouts.partials.navbar')
@include('backend.layouts.partials.sidebar')

<div class="content-wrapper">
    @yield('content')
</div>

@include('backend.layouts.shared.footer')
