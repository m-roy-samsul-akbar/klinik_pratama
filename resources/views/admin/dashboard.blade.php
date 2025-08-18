@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="font-weight-bold">Selamat Datang, Di Dashboard {{ Auth::user()->name }}</h3>
            <h6 class="font-weight-normal mb-0">
                Dashboard Admin -
                <span class="text-primary">{{ $menunggu }} pasien menunggu!</span>
            </h6>
        </div>
        <div class="col-md-4 text-right">
            {{-- Form Filter Bulan & Tahun --}}
            <form method="GET" action="{{ route('admin.dashboard') }}" class="form-inline justify-content-end">
                {{-- Pilih Bulan --}}
                <select name="bulan" class="form-control mr-2">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}"
                            {{ request('bulan', $bulan ?? date('n')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                {{-- Pilih Tahun --}}
                <select name="tahun" class="form-control mr-2">
                    @foreach (range(date('Y'), date('Y') - 5) as $y)
                        <option value="{{ $y }}"
                            {{ request('tahun', $tahun ?? date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row">
        <div class="col-md-3 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Pasien Hari Ini</p>
                    <p class="fs-30 mb-2">{{ $totalHariIni }}</p>
                    <p>Pasien</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Pasien Bulan Ini</p>
                    <p class="fs-30 mb-2">{{ $totalBulanIni }}</p>
                    <p>Pasien</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Poli Umum</p>
                    <p class="fs-30 mb-2">{{ $totalUmum }}</p>
                    <p>Pasien</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Poli Gigi</p>
                    <p class="fs-30 mb-2">{{ $totalGigi }}</p>
                    <p>Pasien</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Statistik --}}
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Statistik Pasien {{ \Carbon\Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F') }}
                        {{ $tahun }}</h4>
                    <canvas id="chartPasien" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Pie --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Perbandingan Poli</h4>
                    <canvas id="chartPoli" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart Pasien Bulanan
        const ctx = document.getElementById('chartPasien').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData->pluck('tanggal')) !!},
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: {!! json_encode($chartData->pluck('jumlah')) !!},
                    borderWidth: 3,
                    borderColor: '#4B49AC',
                    backgroundColor: 'rgba(75,73,172,0.2)',
                    fill: true,
                    tension: 0.3
                }]
            }
        });

        // Pie Chart Perbandingan Poli
        const ctxPie = document.getElementById('chartPoli').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Poli Umum', 'Poli Gigi'],
                datasets: [{
                    data: [{{ $totalUmum }}, {{ $totalGigi }}],
                    backgroundColor: ['#4B49AC', '#FFC107']
                }]
            }
        });
    </script>
@endsection
