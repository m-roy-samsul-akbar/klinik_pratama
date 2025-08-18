@extends('layouts.main')

@section('content')
    <section class="home-slider owl-carousel">
        @include('partials.slider')
    </section>

    <section class="ftco-intro">
        <div class="container ftco-intro">
            <div class="row justify-content-center text-white">

                <!-- Kasus Darurat -->
                <div class="col-md-5 color-1 p-4 text-center">
                    <h3 class="mb-3">Kasus Darurat</h3>
                    <p>Hubungi Kontak Dibawah Ini:</p>
                    <h4 class="mb-1 text-white">0853-2971-6127</h4>
                    <h5 class="text-white">drtamtomo@gmail.com</h5>
                </div>

                <!-- Buka -->
                <div class="col-md-5 color-2 p-4">
                    <h3 class="mb-3 text-center">Buka</h3>
                    <div class="openinghours d-flex flex-column gap-2">

                        @php
                            $jadwal = [
                                'Senin' => '08:00 - 12:00, 16:00 - 20:00',
                                'Selasa' => '08:00 - 12:00, 16:00 - 20:00',
                                'Rabu' => '08:00 - 12:00, 16:00 - 20:00',
                                'Kamis' => '08:00 - 12:00, 16:00 - 20:00',
                                'Jumat' => '08:00 - 12:00, 16:00 - 20:00',
                                'Sabtu' => '08:00 - 12:00, 16:00 - 20:00',
                                'Minggu' => 'Tutup',
                            ];
                        @endphp

                        @foreach ($jadwal as $hari => $jam)
                            <div class="d-flex justify-content-between text-white">
                                <span>{{ $hari }}</span>
                                <span>{{ $jam }}</span>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- POLI -->
    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <h2 class="mb-2">Layanan Kami </h2>
                    <p>Layanan terbaik hanya untuk anda</p>
                </div>
            </div>
            <!-- Tambahkan justify-content-center di sini -->
            <div class="row justify-content-center">
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-tooth-1"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Poli Gigi</h3>
                            <p>Poli Gigi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <i class="fas fa-stethoscope fa-2x text-primary"></i>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Poli Umum</h3>
                            <p>Poli Umum</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- DOKTER -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <h2 class="mb-3">Dokter Kami</h2>
                    <p>Dengan pelayanan profesional, ramah, dan berlandaskan nilai-nilai Islami, kami siap memberikan
                        perawatan terbaik untuk kesehatan jasmani dan rohani Anda.</p>
                </div>
            </div>
            <!-- Tambahkan justify-content-center -->
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
                    <div class="staff">
                        <div class="img mb-4" style="background-image: url(assets/images/pp2.png);"></div>
                        <div class="info text-center">
                            <h3><a href="teacher-single.html">dr. Fritzie Cheria</a></h3>
                            <span class="position">Poli Umum</span>
                            <div class="text">
                                <p>Senin - Sabtu</p>
                                <a>Pagi (08:00 - 12:00 WIB)</a>
                                <p>Sore (17:00 - 20:00 WIB)</p>
                                <ul class="ftco-social">
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
                    <div class="staff">
                        <div class="img mb-4" style="background-image: url(assets/images/pp.png);"></div>
                        <div class="info text-center">
                            <h3><a href="teacher-single.html">drg. Dheny Ariestyani</a></h3>
                            <span class="position">Poli Gigi</span>
                            <div class="text">
                                <p>Senin & Selasa </p>
                                <p>Siang (12:00 - 15:00 WIB)</p>
                                <ul class="ftco-social">
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FASILITAS -->
    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <h2 class="mb-2">Fasilitas Kami</h2>
                    <p>Fasilitas terbaik untuk kenyamanan anda.</p>
                </div>
            </div>

            <div class="row">
                <!-- Gambar 1 -->
                <div class="col-md-4 text-center ftco-animate">
                    <div class="service">
                        <img src="{{ asset('assets/images/f1.jpg') }}" alt="Ruang Istirahat Keluarga Pasien"
                            class="img-fluid rounded mb-3">
                        <h4>Ruang Istirahat Keluarga Pasien</h4>
                        <p>Area bersih dan nyaman untuk keluarga menunggu.</p>
                    </div>
                </div>

                <!-- Gambar 2 -->
                <div class="col-md-4 text-center ftco-animate">
                    <div class="service">
                        <img src="{{ asset('assets/images/f2.jpg') }}" alt="Farmasi" class="img-fluid rounded mb-3">
                        <h4>Farmasi</h4>
                        <p>Tempat penyimpanan dan penjualan obat-obatan.</p>
                    </div>
                </div>

                <!-- Gambar 3 -->
                <div class="col-md-4 text-center ftco-animate">
                    <div class="service">
                        <img src="{{ asset('assets/images/f3.jpg') }}" alt="Musholla Hj Zaenab Masykuri"
                            class="img-fluid rounded mb-3">
                        <h4>Musholla Hj Zaenab Masykuri</h4>
                        <p>Tempat ibadah yang bersih dan nyaman.</p>
                    </div>
                </div>

                <!-- Gambar 4 -->
                <div class="col-md-4 text-center ftco-animate">
                    <div class="service">
                        <img src="{{ asset('assets/images/f4.jpg') }}" alt="Musholla Hj Zaenab Masykuri"
                            class="img-fluid rounded mb-3">
                        <h4>Test Swab Antigen dan Rapid Test Antibodi</h4>
                        <p>Layanan pemeriksaan COVID-19.</p>
                    </div>
                </div>

                <!-- Gambar 5 -->
                <div class="col-md-4 text-center ftco-animate">
                    <div class="service">
                        <img src="{{ asset('assets/images/f5.jpg') }}" alt="Musholla Hj Zaenab Masykuri"
                            class="img-fluid rounded mb-3">
                        <h4>Laboratorium</h4>
                        <p>Ruang pemeriksaan dan analisis sampel medis.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="ftco-section">
    </section>

    @include('layouts.footer')


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
@endsection
