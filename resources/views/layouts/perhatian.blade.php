<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Perhatian')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/perhatian.css') }}" rel="stylesheet" />
</head>

<body data-verifikasi-url="{{ url('/verifikasi') }}">
    @yield('content')

    <div class="alert alert-warning alert-dismissible fade show alert-box" id="alert-box" role="alert">
        <strong>Peringatan!</strong> Harap setujui ketentuan sebelum melanjutkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/perhatian.js') }}"></script>
</body>

</html>
