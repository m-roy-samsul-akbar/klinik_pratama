<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Verifikasi Data')</title>

    <!-- Link CSS eksternal -->
    <link rel="stylesheet" href="{{ asset('assets/css/data.css') }}">
    @stack('styles')
</head>

<body>
    <div class="container fade-in">
        <div class="header">
            @yield('header', 'Verifikasi Data')
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>

</html>
