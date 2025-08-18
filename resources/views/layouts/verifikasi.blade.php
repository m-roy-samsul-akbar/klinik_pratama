<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Form Verifikasi')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/verifikasi.css') }}">
    @stack('styles')
</head>

<body>
    <div class="card fade-in">
        <div class="header">
            @yield('header', 'Pendaftaran Online')
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/verifikasi.js') }}"></script>
    @stack('scripts')
</body>

</html>
