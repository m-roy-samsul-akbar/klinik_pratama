@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Laporan Kunjungan Pasien</h4>

    <!-- Filter Tanggal: Per Hari atau Per Bulan -->
    <form action="#" method="GET" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Filter Berdasarkan:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter_type" id="filter_hari" value="hari" 
                    {{ request('filter_type', 'hari') == 'hari' ? 'checked' : '' }}>
                <label class="form-check-label" for="filter_hari">Per Hari</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter_type" id="filter_bulan" value="bulan"
                    {{ request('filter_type') == 'bulan' ? 'checked' : '' }}>
                <label class="form-check-label" for="filter_bulan">Per Bulan</label>
            </div>
        </div>

        <!-- Filter Per Hari -->
        <div class="mb-3" id="filterHariContainer" style="{{ request('filter_type', 'hari') == 'hari' ? '' : 'display:none;' }}">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>

        <!-- Filter Per Bulan -->
        <div class="mb-3" id="filterBulanContainer" style="{{ request('filter_type') == 'bulan' ? '' : 'display:none;' }}">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="month" id="bulan" name="bulan" class="form-control" value="{{ request('bulan') }}">
        </div>

        <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
        <a href="#" class="btn btn-success me-2">Export Excel</a>
        <a href="#" class="btn btn-danger">Export PDF</a>
    </form>

    <!-- Tabel Laporan -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Dokter</th>
                            <th>Poli</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2025-06-01</td>
                            <td>Ayu Lestari</td>
                            <td>dr. Andi Wijaya</td>
                            <td>Umum</td>
                            <td>Selesai</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2025-06-01</td>
                            <td>Budi Santoso</td>
                            <td>dr. Siti Rahma</td>
                            <td>Anak</td>
                            <td>Menunggu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterHariRadio = document.getElementById('filter_hari');
    const filterBulanRadio = document.getElementById('filter_bulan');
    const filterHariContainer = document.getElementById('filterHariContainer');
    const filterBulanContainer = document.getElementById('filterBulanContainer');

    function toggleFilter() {
        if (filterHariRadio.checked) {
            filterHariContainer.style.display = '';
            filterBulanContainer.style.display = 'none';
        } else if (filterBulanRadio.checked) {
            filterHariContainer.style.display = 'none';
            filterBulanContainer.style.display = '';
        }
    }

    filterHariRadio.addEventListener('change', toggleFilter);
    filterBulanRadio.addEventListener('change', toggleFilter);
});
</script>
@endsection
