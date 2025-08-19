@php
use App\Models\Dokter;
use App\Models\Pendaftaran;

$dokterId = Dokter::where('user_id', Auth::id())->value('id');
$today    = now()->toDateString();

$pasienHariIni   = $dokterId
    ? Pendaftaran::where('dokter_id', $dokterId)->whereDate('tanggal_registrasi', $today)->count()
    : 0;

$pasienAntrian   = $dokterId
    ? Pendaftaran::where('dokter_id', $dokterId)->whereDate('tanggal_registrasi', $today)
        ->where('status', 'Dalam Perawatan')->count()
    : 0;

/** total pasien unik yg pernah ditangani dokter ini */
$totalPasienUnik = $dokterId
    ? Pendaftaran::where('dokter_id', $dokterId)->distinct('pasien_id')->count('pasien_id')
    : 0;

/** opsional: tidak hadir hari ini */
$pasienTidakHadir = $dokterId
    ? Pendaftaran::where('dokter_id', $dokterId)->whereDate('tanggal_registrasi', $today)
        ->where('status', 'Tidak Hadir')->count()
    : 0;
@endphp

@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="row">
      <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Selamat Datang, {{ Auth::user()->name }}</h3>
        <h6 class="font-weight-normal mb-0">
          Dashboard Dokter —
          <span class="text-primary" id="jumlahAntrian">{{ $pasienAntrian }} pasien menunggu!</span>
        </h6>
        @if(!$dokterId)
          <div class="alert alert-warning mt-2 mb-0">
            Akun Anda belum terhubung ke data <b>Dokter</b> (user_id belum di-set). Hubungi admin.
          </div>
        @endif
      </div>
      <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
          <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                    id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
              <a class="dropdown-item" href="#">Januari - Maret</a>
              <a class="dropdown-item" href="#">Maret - Juni</a>
              <a class="dropdown-item" href="#">Juni - Agustus</a>
              <a class="dropdown-item" href="#">Agustus - November</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 grid-margin transparent">
    <div class="row">
      <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-tale">
          <div class="card-body">
            <p class="mb-4">Pasien Hari Ini</p>
            <p class="fs-30 mb-2" id="jumlahHariIni">{{ $pasienHariIni }}</p>
            <p>Pasien</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-dark-blue">
          <div class="card-body">
            <p class="mb-4">Total Pasien</p>
            <p class="fs-30 mb-2" id="jumlahBulanIni">{{ $totalPasienUnik }}</p>
            <p>Pasien</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
        <div class="card card-light-blue">
          <div class="card-body">
            <p class="mb-4">Pasien Tidak Hadir (hari ini)</p>
            <p class="fs-30 mb-2" id="jumlahKonsultasi">{{ $pasienTidakHadir }}</p>
            <p>Pasien</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 stretch-card transparent">
        <div class="card card-light-danger">
          <div class="card-body">
            <p class="mb-4">Antrian</p>
            <p class="fs-30 mb-2" id="jumlahAntrianBox">{{ $pasienAntrian }}</p>
            <p>Pasien menunggu</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 grid-margin stretch-card">
    <div class="card tale-bg position-relative">
      <div class="card-people mt-auto">
        <img src="{{ asset('admin/images/dashboard/people.svg') }}" alt="people" />
      </div>
      {{-- Widget Cuaca --}}
      <div id="weatherWidget"
           class="position-absolute text-white p-3 rounded"
           style="top: 15px; right: 15px; background: rgba(0,0,0,0.5);">
        <h5 id="cityName">Loading...</h5>
        <p class="mb-0" id="temperature">-- °C</p>
        <small id="weatherDesc">---</small>
      </div>
    </div>
  </div>
</div>

{{-- TABEL PASIEN HARI INI --}}
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">Daftar Pasien Hari Ini</p>
        <div class="table-responsive">
          <table class="table table-striped table-borderless">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="daftarPasienBody">
              <!-- Diisi via JS realtime -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- WEATHER + REALTIME --}}
<script>
  // === WEATHER ===
  const apiKey = "abb4fa79d7f206a889bbfccd372e1714";
  const city   = "Tegal";

  function fetchWeather() {
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=id&appid=${apiKey}`)
      .then(r => r.json())
      .then(data => {
        document.getElementById("cityName").innerText   = data.name;
        document.getElementById("temperature").innerText = `${Math.round(data.main.temp)} °C`;
        document.getElementById("weatherDesc").innerText = data.weather[0].description;
      })
      .catch(err => console.error("Gagal ambil cuaca:", err));
  }

  // === REALTIME DASHBOARD ===
  function refreshTable() {
    fetch(@json(route('dashboard.realtime')), { credentials: 'same-origin' })
      .then(r => r.json())
      .then(j => {
        if (j.status !== 'ok') return;

        // Update angka
        document.getElementById('jumlahAntrian').textContent   = `${j.counts.antrian} pasien menunggu!`;
        document.getElementById('jumlahAntrianBox').textContent= j.counts.antrian;
        document.getElementById('jumlahHariIni').textContent   = j.counts.pasien_hari_ini;
        document.getElementById('jumlahKonsultasi').textContent= j.counts.tidak_hadir;
        // (total pasien unik tidak perlu realtime, biasanya tetap)

        // Render tabel
        const tbody = document.getElementById('daftarPasienBody');
        tbody.innerHTML = j.rows.map((row, idx) => `
          <tr>
             <td>${idx + 1}</td>
            <td>${row.nama}</td>
            <td>${row.keluhan ?? '-'}</td>
            <td>${row.status}</td>
          </tr>
        `).join('');
      })
      .catch(console.error);
  }

  document.addEventListener('DOMContentLoaded', () => {
    fetchWeather();
    setInterval(fetchWeather, 600000); // 10 menit

    refreshTable();
    setInterval(refreshTable, 10000);  // 10 detik
  });
</script>
@endsection

@section('scripts')
@endsection
