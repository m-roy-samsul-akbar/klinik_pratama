@extends('layouts.admin')

@section('title', 'Rekam Medis Pasien')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Rekam Medis Pasien</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Rekam Medis</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Periksa</th>
                                <th>Keluhan</th>
                                <th>Dokter</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekamMedis as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>RM{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{{ $item->pendaftaran->dokter->nama }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailKajianAwal"
                                            data-nama="{{ $item->pendaftaran->pasien->nama }}"
                                            data-suhu="{{ $item->suhu_tubuh }}" data-tekanan="{{ $item->tekanan_darah }}"
                                            data-tinggi="{{ $item->tinggi_badan }}" data-berat="{{ $item->berat_badan }}"
                                            data-keluhan="{{ $item->keluhan }}"
                                            data-tanggal="{{ $item->created_at->format('Y-m-d') }}">
                                            Lihat
                                        </button>

                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data rekam medis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kajian Awal -->
    <div class="modal fade" id="modalDetailKajianAwal" tabindex="-1" aria-labelledby="modalDetailKajianAwalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDetailKajianAwalLabel">Detail Kajian Awal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="detailNama" class="form-label">Nama Pasien</label>
                        <input type="text" id="detailNama" class="form-control" readonly>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="detailSuhu" class="form-label">Suhu Tubuh (°C)</label>
                            <input type="text" id="detailSuhu" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="detailTekanan" class="form-label">Tekanan Darah (mmHg)</label>
                            <input type="text" id="detailTekanan" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="detailTinggi" class="form-label">Tinggi Badan (cm)</label>
                            <input type="text" id="detailTinggi" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="detailBerat" class="form-label">Berat Badan (kg)</label>
                            <input type="text" id="detailBerat" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="detailTanggal" class="form-label">Tanggal Periksa</label>
                            <input type="text" id="detailTanggal" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="detailKeluhan" class="form-label">Keluhan</label>
                        <textarea id="detailKeluhan" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
