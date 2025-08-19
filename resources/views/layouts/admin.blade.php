<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- penting untuk AJAX/fetch (hindari 419 + HTML balikannya) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Klinik Pratama Aisyiyah')</title>

    {{-- plugins:css --}}
    <link rel="stylesheet" href="{{ asset('admin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">

    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/select.dataTables.min.css') }}">

    {{-- icons & fonts --}}
    <link rel="stylesheet" href="{{ asset('admin/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    {{-- theme css --}}
    <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jadwaldokter.css') }}">

    <link rel="icon" href="{{ asset('assets/images/logoklinik1.png') }}">

    @stack('styles')
</head>

<body>
    <div class="container-scroller">

        @include('admin.partials.navbar')

        <div class="container-fluid page-body-wrapper">

            @include('admin.partials.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="alert alert-success fade show" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger fade show" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Copyright © {{ date('Y') }}. Klinik Pratama Aisyiyah Hj. Mafroh. All rights reserved.
                        </span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                            Dibangun & dirancang dengan ❤️ untuk pelayanan kesehatan terbaik
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    {{-- plugins:js (berisi jQuery + Bootstrap dari template) --}}
    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>

    {{-- library eksternal yang dibutuhkan halaman --}}
    <script src="{{ asset('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.select.min.js') }}"></script>

    {{-- script inti template --}}
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>

    {{-- halaman bawaan template --}}
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/js/Chart.roundedBarCharts.js') }}"></script>

    {{-- custom modules (pastikan di-load SETELAH vendor + jQuery) --}}
    <script src="{{ asset('admin/js/jadwaldokter.js') }}"></script>
    <script src="{{ asset('admin/js/registrasi.js') }}"></script>
    <script src="{{ asset('admin/js/rekammedis.js') }}"></script>
    script src="{{ asset('admin/js/datapasien.js') }}"></script>
    <script src="{{ asset('admin/js/dokter.js') }}"></script>

    {{-- SweetAlert2 (opsional, jika dipakai di halaman lain) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Chart.js CDN (jika butuh versi terbaru, boleh dibiarkan) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Set default CSRF header untuk semua $.ajax (jaga2 kalau ada request jQuery) --}}
    <script>
        (function() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            if (window.jQuery) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>
