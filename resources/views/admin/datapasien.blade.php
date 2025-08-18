@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Data Pasien</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Nomor Rekam Medis</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kajianAwals as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama }}</td>
                                    <td>RM{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $item->pendaftaran->pasien->jenis_kelamin }}</td>
                                    <td>{{ $item->pendaftaran->pasien->alamat }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPasien"
                                            data-nama="{{ $item->pendaftaran->pasien->nama }}"
                                            data-nik="{{ $item->pendaftaran->pasien->nik }}"
                                            data-tempat_lahir="{{ $item->pendaftaran->pasien->tempat_lahir }}"
                                            data-tanggal_lahir="{{ $item->pendaftaran->pasien->tanggal_lahir }}"
                                            data-jenis_kelamin="{{ $item->pendaftaran->pasien->jenis_kelamin }}"
                                            data-nama_ayah="{{ $item->pendaftaran->pasien->nama_ayah }}"
                                            data-nama_ibu="{{ $item->pendaftaran->pasien->nama_ibu }}"
                                            data-agama="{{ $item->pendaftaran->pasien->agama }}"
                                            data-alamat="{{ $item->pendaftaran->pasien->alamat }}"
                                            data-pendidikan="{{ $item->pendaftaran->pasien->pendidikan }}"
                                            data-pekerjaan="{{ $item->pendaftaran->pasien->pekerjaan }}"
                                            data-status="{{ $item->pendaftaran->pasien->status }}"
                                            data-penanggung_hubungan="{{ $item->pendaftaran->pasien->penanggung_hubungan }}"
                                            data-penanggung_nama="{{ $item->pendaftaran->pasien->penanggung_nama }}"
                                            data-penanggung_alamat="{{ $item->pendaftaran->pasien->penanggung_alamat }}"
                                            data-penanggung_pekerjaan="{{ $item->pendaftaran->pasien->penanggung_pekerjaan }}"
                                            data-penanggung_gender="{{ $item->pendaftaran->pasien->penanggung_gender }}"
                                            data-penanggung_agama="{{ $item->pendaftaran->pasien->penanggung_agama }}"
                                            data-penanggung_status="{{ $item->pendaftaran->pasien->penanggung_status }}"
                                            data-no_whatsapp="{{ $item->pendaftaran->pasien->no_whatsapp }}"
                                            data-poli="{{ $item->pendaftaran->dokter->spesialis }}"
                                            data-dokter="{{ $item->pendaftaran->dokter->nama }}"
                                            data-jam="{{ $item->pendaftaran->dokter->jam_praktek ?? '-' }}"
                                            data-tanggal_registrasi="{{ $item->pendaftaran->tanggal_registrasi }}">
                                            Detail
                                        </button>

                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada pasien dengan kajian awal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pasien -->
    <div class="modal fade" id="modalDetailPasien" tabindex="-1" aria-labelledby="modalDetailPasienLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalDetailPasienLabel">Detail Pasien</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- DATA DIRI --}}
                    <h5 class="text-center fs-4 fw-bold mb-4">DATA DIRI</h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Pasien</label>
                        <input type="text" id="detail_nama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" id="detail_nik" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" id="detail_tempat_lahir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" id="detail_tanggal_lahir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <input type="text" id="detail_jenis_kelamin" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" id="detail_nama_ayah" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" id="detail_nama_ibu" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <input type="text" id="detail_agama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea id="detail_alamat" class="form-control" rows="3" readonly></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pendidikan</label>
                        <input type="text" id="detail_pendidikan" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" id="detail_pekerjaan" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" id="detail_status" class="form-control" readonly>
                    </div>

                    {{-- PENANGGUNG JAWAB --}}
                    <h5 class="text-center fs-4 fw-bold mt-5 mb-4">PENANGGUNG JAWAB</h5>

                    <div class="mb-3">
                        <label class="form-label">Hubungan Keluarga</label>
                        <input type="text" id="detail_penanggung_hubungan" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" id="detail_penanggung_nama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat </label>
                        <textarea id="detail_penanggung_alamat" class="form-control" rows="3" readonly></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan </label>
                        <input type="text" id="detail_penanggung_pekerjaan" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin </label>
                        <input type="text" id="detail_penanggung_gender" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <input type="text" id="detail_penanggung_agama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" id="detail_penanggung_status" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" id="detail_no_whatsapp" class="form-control" readonly>
                    </div>

                    {{-- JADWAL DOKTER --}}
                    <h5 class="text-center fs-4 fw-bold mt-5 mb-4">JADWAL DOKTER</h5>

                    <div class="mb-3">
                        <label class="form-label">Poli</label>
                        <input type="text" id="detail_poli" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dokter</label>
                        <input type="text" id="detail_dokter" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Praktek</label>
                        <input type="text" id="detail_jam" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Registrasi</label>
                        <input type="text" id="detail_tanggal_registrasi" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
