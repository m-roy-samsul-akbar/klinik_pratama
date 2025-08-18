<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Halaman Pendaftaran')</title>

    <!-- Link to external CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/verifikasi2.css') }}">
    @stack('styles')
</head>

<body>
    <div class="container">
        <div class="header">
            @yield('header', 'Pendaftaran Online')
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>

</html>
