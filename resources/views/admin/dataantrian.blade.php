@extends('layouts.admin')

@section('title', 'Data Antrian')

@section('content')
    <div class="container-fluid">

        {{-- Header + Filter --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Data Antrian Pasien</h4>

            <style>
                .filter-form>* {
                    margin-right: 10px;
                }

                .filter-form>*:last-child {
                    margin-right: 0;
                }
            </style>

            <form method="GET" action="{{ route('admin.dataantrian') }}" class="filter-form d-flex align-items-center">
                <input type="date" name="tanggal" id="inputTanggal" class="form-control form-control-sm"
                    value="{{ $tanggal }}" style="max-width: 160px;">

                <button type="submit" class="btn btn-primary btn-sm ms-custom">Filter</button>

                <button type="button" class="btn btn-secondary btn-sm ms-custom" onclick="resetTanggal()">Reset</button>
            </form>
        </div>

        {{-- ANTRIAN POLI UMUM --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Antrian Poli Umum</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nomor Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
                                <th>Tanggal Registrasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($antrianUmum as $index => $antrian)
                                <tr>
                                    <td>{{ $index + 1 + ($antrianUmum->currentPage() - 1) * $antrianUmum->perPage() }}</td>
                                    <td>{{ $antrian->nomor_antrian }}</td>
                                    <td>{{ $antrian->pasien->nama }}</td>
                                    <td>{{ $antrian->dokter->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($antrian->tanggal_registrasi)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($antrian->status === 'Belum Kajian Awal')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif ($antrian->status === 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif ($antrian->status === 'Dalam Perawatan')
                                            <span class="badge bg-info">Dalam Perawatan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($antrian->status === 'Belum Kajian Awal')
                                            <form method="POST" action="{{ route('antrian.panggil', $antrian->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Panggil</button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada antrian pada tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Poli Umum --}}
            <div class="mt-2 px-3">
                {{ $antrianUmum->appends(['tanggal' => $tanggal])->links() }}
            </div>
        </div>

        {{-- ANTRIAN POLI GIGI --}}
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <strong>Antrian Poli Gigi</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nomor Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
                                <th>Tanggal Registrasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($antrianGigi as $index => $antrian)
                                <tr>
                                    <td>{{ $index + 1 + ($antrianGigi->currentPage() - 1) * $antrianGigi->perPage() }}</td>
                                    <td>{{ $antrian->nomor_antrian }}</td>
                                    <td>{{ $antrian->pasien->nama }}</td>
                                    <td>{{ $antrian->dokter->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($antrian->tanggal_registrasi)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($antrian->status === 'Belum Kajian Awal')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif ($antrian->status === 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif ($antrian->status === 'Dalam Perawatan')
                                            <span class="badge bg-info">Dalam Perawatan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($antrian->status === 'Belum Kajian Awal')
                                            <form method="POST" action="{{ route('antrian.panggil', $antrian->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Panggil</button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada antrian pada tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Poli Gigi --}}
            <div class="mt-2 px-3">
                {{ $antrianGigi->appends(['tanggal' => $tanggal])->links() }}
            </div>
        </div>
    </div>

    <script>
        function resetTanggal() {
            const input = document.getElementById('inputTanggal');
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            input.value = `${yyyy}-${mm}-${dd}`;

            input.form.submit(); // langsung submit setelah reset
        }
    </script>

@endsection
