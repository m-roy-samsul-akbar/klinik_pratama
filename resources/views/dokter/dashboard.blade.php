@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Selamat Datang, Dr. {{ Auth::user()->name }}</h3>
                <h6 class="font-weight-normal mb-0">
                    Dashboard Dokter - <span class="text-primary" id="jumlahAntrian">5 pasien menunggu!</span>
                </h6>
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
                        <p class="fs-30 mb-2" id="jumlahHariIni">0</p>
                        <p>Pasien</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Pasien</p>
                        <p class="fs-30 mb-2" id="jumlahBulanIni">0</p>
                        <p>Pasien</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Pasien Tidak Hadir</p>
                        <p class="fs-30 mb-2" id="jumlahKonsultasi">0</p>
                        <p>Pasien</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Antrian</p>
                        <p class="fs-30 mb-2" id="jumlahAntrianBox">0</p>
                        <p>Pasien menunggu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="{{ asset('admin/images/dashboard/people.svg') }}" alt="people" />
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
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Jam</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="daftarPasienBody">
                            <!-- Akan diisi otomatis oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function fetchRealtimeDashboard() {
        fetch("{{ route('dashboard.realtime') }}")
            .then(response => response.json())
            .then(data => {
                // Update angka-angka dashboard
                document.getElementById('jumlahHariIni').innerText = data.hari_ini;
                document.getElementById('jumlahBulanIni').innerText = data.total_bulan_ini;
                document.getElementById('jumlahKonsultasi').innerText = data.konsultasi;
                document.getElementById('jumlahAntrianBox').innerText = data.antrian;
                document.querySelector('h6 span.text-primary').innerText = `${data.antrian} pasien menunggu!`;

                // Update daftar pasien hari ini
                const tbody = document.getElementById('daftarPasienBody');
                tbody.innerHTML = '';
                data.pasien.forEach(p => {
                    const badgeClass = p.status === 'Selesai'
                        ? 'badge-success'
                        : (p.status === 'Sedang dilayani' ? 'badge-warning' : 'badge-info');

                    const row = `
                        <tr>
                            <td>${p.nomor_rm}</td>
                            <td class="font-weight-bold">${p.nama}</td>
                            <td>${p.jam}</td>
                            <td>${p.keluhan}</td>
                            <td class="font-weight-medium">
                                <div class="badge ${badgeClass}">${p.status}</div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            });
    }

    // Jalankan saat halaman load dan setiap 10 detik
    document.addEventListener('DOMContentLoaded', () => {
        fetchRealtimeDashboard();
        setInterval(fetchRealtimeDashboard, 10000);
    });
</script>
@endsection
