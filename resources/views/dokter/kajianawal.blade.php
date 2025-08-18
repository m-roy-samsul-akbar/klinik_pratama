@extends('layouts.dokter')

@section('title', 'Kajian Awal Pasien')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Kajian Awal Pasien</h4>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Suhu Tubuh (°C)</th>
                                <th>Tekanan Darah</th>
                                <th>Tinggi (cm)</th>
                                <th>Berat (kg)</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kajianAwals as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama }}</td>
                                    <td>{{ $item->suhu_tubuh }}</td>
                                    <td>{{ $item->tekanan_darah }}</td>
                                    <td>{{ $item->tinggi_badan }}</td>
                                    <td>{{ $item->berat_badan }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalKajianAwal"
                                            onclick="isiDataDiagnosa(
                                            '{{ $item->id }}',
                                            '{{ $item->pendaftaran->pasien->nama }}',
                                            '{{ $item->suhu_tubuh }}',
                                            '{{ $item->tekanan_darah }}',
                                            '{{ $item->tinggi_badan }}',
                                            '{{ $item->berat_badan }}',
                                            `{{ $item->keluhan }}`,
                                            '{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}'
                                        )">
                                            Tambah Diagnosis
                                        </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data kajian awal.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Diagnosis -->
    <div class="modal fade" id="modalKajianAwal" tabindex="-1" aria-labelledby="modalKajianAwalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-sm">
                <form action="{{ route('dokter.kajian.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="kajian_id">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalKajianAwalLabel">Detail Kajian Awal</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Suhu Tubuh (°C)</label>
                                <input type="text" class="form-control" id="suhu_tubuh" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tekanan Darah</label>
                                <input type="text" class="form-control" id="tekanan_darah" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tinggi Badan (cm)</label>
                                <input type="text" class="form-control" id="tinggi_badan" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berat Badan (kg)</label>
                                <input type="text" class="form-control" id="berat_badan" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Periksa</label>
                                <input type="text" class="form-control" id="tanggal_periksa" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan" rows="2" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="4" placeholder="Masukkan diagnosis" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="obat" class="form-label">Obat / Resep</label>
                            <textarea class="form-control" name="obat" id="obat" rows="3" placeholder="Masukkan nama obat atau resep"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $kajianAwals->links() }}
    </div>

@endsection
