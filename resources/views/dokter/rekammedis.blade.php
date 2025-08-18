@extends('layouts.dokter')

@section('title', 'Rekam Medis Pasien')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Rekam Medis Pasien</h4>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('rekammedis.index') }}" class="d-flex align-items-end" style="gap: 10px;">
                <div>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div>
                    <button type="submit" class="btn" style="background-color: #44389A; color: white;">Filter</button>
                </div>
                <div>
                    <a href="{{ route('rekammedis.index', ['tanggal' => now()->format('Y-m-d')]) }}"
                        class="btn btn-secondary" style="background-color: #9F9F9F; color: white;">
                        Reset
                    </a>
                </div>
            </form>
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
                                <th>Diagnosis</th>
                                <th>Obat</th>
                                <th>Dokter</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekamMedis as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nomor_rekam_medis ?? '-' }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{{ $item->diagnosis }}</td>
                                    <td>{{ $item->obat ?? '-' }}</td>
                                    <td>{{ $item->pendaftaran->dokter->nama }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailKajianAwal"
                                            data-nomor="{{ $item->nomor_rekam_medis ?? '-' }}"
                                            data-nama="{{ $item->pendaftaran->pasien->nama }}"
                                            data-suhu="{{ $item->suhu_tubuh }}" data-tekanan="{{ $item->tekanan_darah }}"
                                            data-tinggi="{{ $item->tinggi_badan }}" data-berat="{{ $item->berat_badan }}"
                                            data-keluhan="{{ $item->keluhan }}" data-diagnosis="{{ $item->diagnosis }}"
                                            data-obat="{{ $item->obat }}"
                                            data-tanggal="{{ $item->created_at->format('Y-m-d') }}">
                                            Lihat
                                        </button>

                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEditRekamMedis" data-id="{{ $item->id }}"
                                            data-nomor="{{ $item->nomor_rekam_medis }}"
                                            data-nama="{{ $item->pendaftaran->pasien->nama }}"
                                            data-suhu="{{ $item->suhu_tubuh }}" data-tekanan="{{ $item->tekanan_darah }}"
                                            data-tinggi="{{ $item->tinggi_badan }}" data-berat="{{ $item->berat_badan }}"
                                            data-tanggal="{{ $item->created_at->format('Y-m-d') }}"
                                            data-keluhan="{{ $item->keluhan }}" data-diagnosis="{{ $item->diagnosis }}"
                                            data-obat="{{ $item->obat }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Belum ada data rekam medis.</td>
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
                        <label for="detailNomorRM" class="form-label">Nomor Rekam Medis</label>
                        <input type="text" id="detailNomorRM" class="form-control" readonly>
                    </div>
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
                    <div class="mb-3">
                        <label for="detailDiagnosis" class="form-label">Diagnosis</label>
                        <textarea id="detailDiagnosis" class="form-control" rows="3" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detailObat" class="form-label">Obat</label>
                        <textarea id="detailObat" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Rekam Medis -->
    <div class="modal fade" id="modalEditRekamMedis" tabindex="-1" aria-labelledby="modalEditRekamMedisLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('dokter.kajian.update') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="editKajianId">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditRekamMedisLabel">Edit Rekam Medis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNomorRM" class="form-label">Nomor Rekam Medis</label>
                        <input type="text" id="editNomorRM" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama Pasien</label>
                        <input type="text" id="editNama" class="form-control" readonly>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="editSuhu" class="form-label">Suhu Tubuh (°C)</label>
                            <input type="text" id="editSuhu" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="editTekanan" class="form-label">Tekanan Darah (mmHg)</label>
                            <input type="text" id="editTekanan" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="editTinggi" class="form-label">Tinggi Badan (cm)</label>
                            <input type="text" id="editTinggi" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editBerat" class="form-label">Berat Badan (kg)</label>
                            <input type="text" id="editBerat" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="editTanggal" class="form-label">Tanggal Periksa</label>
                            <input type="text" id="editTanggal" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editKeluhan" class="form-label">Keluhan</label>
                        <textarea id="editKeluhan" class="form-control" rows="2" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editDiagnosis" class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" id="editDiagnosis" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editObat" class="form-label">Obat</label>
                        <textarea name="obat" id="editObat" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $rekamMedis->withQueryString()->links() }}
    </div>

@endsection
