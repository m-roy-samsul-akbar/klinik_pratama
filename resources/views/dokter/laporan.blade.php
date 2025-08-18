@extends('layouts.dokter')

@section('title', 'Laporan')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Laporan Kunjungan Pasien</h4>

        <!-- Filter Tanggal -->
        <form action="{{ route('dokter.laporan') }}" method="GET" class="mb-4" id="filterForm">
            <div class="mb-3 d-flex align-items-center">
                <label class="form-label mb-0 me-2">Filter Berdasarkan:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="filter_type" id="filter_hari" value="hari"
                        {{ request('filter_type', 'hari') == 'hari' ? 'checked' : '' }} onchange="toggleFilterFields()">
                    <label class="form-check-label" for="filter_hari">Per Hari</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="filter_type" id="filter_bulan" value="bulan"
                        {{ request('filter_type') == 'bulan' ? 'checked' : '' }} onchange="toggleFilterFields()">
                    <label class="form-check-label" for="filter_bulan">Per Bulan</label>
                </div>
            </div>

            <!-- Filter Per Hari -->
            <div class="mb-3" id="filterHariContainer"
                style="{{ request('filter_type', 'hari') == 'hari' ? '' : 'display:none;' }}">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <!-- Filter Per Bulan -->
            <div class="mb-3" id="filterBulanContainer"
                style="{{ request('filter_type') == 'bulan' ? '' : 'display:none;' }}">
                <label for="bulan" class="form-label">Bulan</label>
                <input type="month" id="bulan" name="bulan" class="form-control" value="{{ request('bulan') }}">
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="{{ route('laporan.export.excel') }}" class="btn btn-success">Export Excel</a>
                <a href="{{ route('laporan.export.pdf') }}" class="btn btn-danger">Export PDF</a>
            </div>
        </form>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th>Diagnosis</th>
                                <th>Obat/Resep</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $i => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $i }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama ?? '-' }}</td>
                                    <td>{{ $item->keluhan ?? '-' }}</td>
                                    <td>{{ $item->diagnosis ?? '-' }}</td>
                                    <td>{{ $item->obat ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            function toggleFilterFields() {
                const type = document.querySelector('input[name="filter_type"]:checked').value;
                const hariContainer = document.getElementById('filterHariContainer');
                const bulanContainer = document.getElementById('filterBulanContainer');

                if (type === 'hari') {
                    hariContainer.style.display = '';
                    bulanContainer.style.display = 'none';
                    document.getElementById('bulan').value = '';
                } else {
                    hariContainer.style.display = 'none';
                    bulanContainer.style.display = '';
                    document.getElementById('tanggal').value = '';
                }
            }

            document.addEventListener('DOMContentLoaded', toggleFilterFields);
        </script>
    @endsection
