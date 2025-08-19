{{-- resources/views/pages/buktipendaftaran.blade.php --}}
@extends('layouts.main')

@section('title', 'Bukti Pendaftaran - Klinik Pratama Aisyiyah Hj Mafroh')

@section('content')
    <!-- Header Slider -->
    <section class="home-slider owl-carousel">
        <div class="slider-item bread-item" style="background-image: url('{{ asset('assets/images/tempat3.jpg') }}');"
            data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container" data-scrollax-parent="true">
                <div class="row slider-text align-items-end">
                    <div class="col-md-7 col-sm-12 ftco-animate mb-5">
                        <p class="breadcrumbs">
                            <span class="mr-2"><a href="{{ url('/') }}">Home</a></span>
                            <span class="mr-2"><a href="{{ route('bukti.pendaftaran') }}">Bukti Pendaftaran</a></span>
                        </p>
                        <h1 class="mb-3">Bukti Pendaftaran</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        use Carbon\Carbon;
    @endphp

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Bukti Pendaftaran</h3>
                            <p class="text-muted mb-4">
                                Masukkan <strong>NIK</strong> (opsional pilih tanggal) untuk menampilkan bukti pendaftaran.
                            </p>

                            {{-- Form pencarian --}}
                            <form action="{{ route('bukti.pendaftaran') }}" method="GET" class="mb-4">
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="nik" class="form-control"
                                            placeholder="Contoh: 327106xxxxxxxxxx" value="{{ old('nik', $nik) }}"
                                            minlength="16" maxlength="16" required>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search mr-1"></i> Cek Bukti
                                        </button>
                                    </div>
                                </div>
                                @error('nik')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('tanggal')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>

                            @if ($nik && !$pendaftaran)
                                {{-- Tidak ditemukan --}}
                                <div class="alert alert-warning">
                                    <strong>Data tidak ditemukan.</strong>
                                    @if ($tanggal)
                                        Tidak ada pendaftaran untuk NIK <code>{{ $nik }}</code> pada tanggal
                                        <code>{{ Carbon::parse($tanggal)->translatedFormat('d F Y') }}</code>.
                                    @else
                                        Tidak ada pendaftaran terbaru untuk NIK <code>{{ $nik }}</code>.
                                    @endif
                                </div>
                            @endif

                            @if ($pendaftaran)
                                {{-- Tampilan bukti pendaftaran --}}
                                <div id="print-area" class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('assets/images/klinik.png') }}" alt="logo"
                                            style="height:60px" class="mr-3">
                                        <div>
                                            <h5 class="mb-0">Klinik Pratama Aisyiyah Hj Mafroh</h5>
                                            <small class="text-muted">Bukti Pendaftaran Pasien</small>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <span class="badge badge-info p-2"> NIK: {{ $pendaftaran->pasien->nik }}</span>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        {{-- =======================
                                             SECTION 1: DATA DIRI
                                             ======================= --}}
                                        <div class="col-md-6 mb-3">
                                            <h5 class="mb-3">Data Diri Pasien</h5>
                                            <dl class="row mb-0">
                                                <dt class="col-5">Nama Pasien</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->nama }}</dd>

                                                <dt class="col-5">NIK</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->nik }}</dd>

                                                <dt class="col-5">Tempat, Tgl Lahir</dt>
                                                <dd class="col-7">:
                                                    {{ $pendaftaran->pasien->tempat_lahir }},
                                                    {{ Carbon::parse($pendaftaran->pasien->tanggal_lahir)->translatedFormat('d F Y') }}
                                                </dd>

                                                <dt class="col-5">Jenis Kelamin</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->jenis_kelamin }}</dd>

                                                <dt class="col-5">Agama</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->agama }}</dd>

                                                <dt class="col-5">Alamat</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->alamat }}</dd>

                                                <dt class="col-5">Pendidikan</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->pendidikan }}</dd>

                                                <dt class="col-5">Pekerjaan</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->pekerjaan }}</dd>

                                                <dt class="col-5">Status Kawin</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->status }}</dd>

                                                <dt class="col-5">Nama Ayah</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->nama_ayah }}</dd>

                                                <dt class="col-5">Nama Ibu</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->nama_ibu }}</dd>
                                            </dl>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <h5 class="mb-3">Data Penanggung Jawab</h5>
                                            <dl class="row mb-0">
                                                <dt class="col-5">Hubungan</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_hubungan }}</dd>

                                                <dt class="col-5">Nama</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_nama }}</dd>

                                                <dt class="col-5">Alamat</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_alamat }}</dd>

                                                <dt class="col-5">Gender</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_gender }}</dd>

                                                <dt class="col-5">Agama</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_agama }}</dd>

                                                <dt class="col-5">Pekerjaan</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_pekerjaan }}</dd>

                                                <dt class="col-5">Status</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->penanggung_status }}</dd>
                                            </dl>
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- ==========================
                                         SECTION 2: JADWAL & KONTAK
                                         ========================== --}}
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h5 class="mb-3">Jadwal & Layanan</h5>
                                            <dl class="row mb-0">
                                                <dt class="col-5">Poli / Spesialis</dt>
                                                <dd class="col-7">: Poli {{ $pendaftaran->dokter->spesialis }}</dd>

                                                <dt class="col-5">Dokter</dt>
                                                <dd class="col-7">: {{ $pendaftaran->dokter->nama }}</dd>

                                                <dt class="col-5">Jam Praktek</dt>
                                                <dd class="col-7">: {{ $pendaftaran->dokter->jam_praktek ?? '-' }}</dd>

                                                <dt class="col-5">Tanggal Booking</dt>
                                                <dd class="col-7">:
                                                    {{ Carbon::parse($pendaftaran->tanggal_registrasi)->translatedFormat('d F Y') }}
                                                </dd>

                                                <dt class="col-5">Nomor Antrian</dt>
                                                <dd class="col-7">:
                                                    <strong class="h5 mb-0">{{ $pendaftaran->nomor_antrian }}</strong>
                                                </dd>
                                            </dl>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <h5 class="mb-3">Kontak & Status</h5>
                                            <dl class="row mb-0">
                                                <dt class="col-5">No. WhatsApp</dt>
                                                <dd class="col-7">: {{ $pendaftaran->pasien->no_whatsapp ?? '-' }}</dd>

                                                <dt class="col-5">Status Pendaftaran</dt>
                                                <dd class="col-7">: {{ $pendaftaran->status }}</dd>

                                                <dt class="col-5">Waktu Daftar</dt>
                                                <dd class="col-7">:
                                                    {{ Carbon::parse($pendaftaran->created_at)->translatedFormat('d F Y H:i') }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>

                                    <div class="alert alert-light border mt-3 mb-2">
                                        <small class="text-muted">
                                            Catatan: Datang 10–15 menit lebih awal untuk proses verifikasi. Harap membawa
                                            identitas dan
                                            menunjukkan bukti pendaftaran ini kepada petugas.
                                        </small>
                                    </div>
                                </div>
                            @endif
                            {{-- Akhir bukti pendaftaran --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')
@endsection
