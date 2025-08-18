@extends('layouts.main')

@section('title', 'Cek Antrian - Klinik Pratama Aisyiyah')

@section('content')

    <!-- Header Slider -->
    <section class="home-slider owl-carousel">
        <div class="slider-item bread-item" style="background-image: url('assets/images/tempat3.jpg');"
            data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container" data-scrollax-parent="true">
                <div class="row slider-text align-items-end">
                    <div class="col-md-7 col-sm-12 ftco-animate mb-5">
                        <p class="breadcrumbs">
                            <span class="mr-2"><a href="/">Home</a></span>
                            <span class="mr-2"><a href="/cekantrian">Cek Antrian</a></span>
                        </p>
                        <h1 class="mb-3">Cek Antrian</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="ftco-section contact-section ftco-degree-bg">
        <div class="container text-center">

            <!-- Cek Antrian Poli Card -->
            <div class="cek-antrian-card mx-auto mb-3">
                Cek Antrian Poli
            </div>

            <!-- Tanggal dan Waktu -->
            <h2 class="tanggal">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</h2>
            <h2 id="clock" class="jam mb-4">00:00:00</h2>

            <!-- Kartu Antrian -->
            <div class="row justify-content-center">
                <!-- Poli Umum -->
                <div class="col-md-3 col-6 mb-4">
                    <div class="antrian-card">
                        <div class="antrian-header">NOMOR ANTRIAN</div>
                        <div class="antrian-number umum">U000</div>
                        <div class="antrian-footer">POLIKLINIK UMUM</div>
                    </div>
                </div>

                <!-- Poli Gigi -->
                <div class="col-md-3 col-6 mb-4">
                    <div class="antrian-card" style="background-color: #9b4d9b;">
                        <div class="antrian-header">NOMOR ANTRIAN</div>
                        <div class="antrian-number gigi">G000</div>
                        <div class="antrian-footer">POLIKLINIK GIGI</div>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <p class="text-muted mt-3" style="font-size: 14px;">
                *) Harap datang 10-15 menit sebelum waktu pelayanan sudah berada di klinik.
            </p>
        </div>
    </section>

    @include('layouts.footer')

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
