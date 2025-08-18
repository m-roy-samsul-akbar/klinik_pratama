@extends('layouts.dokter')

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
                                <th>No. Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kajianAwals as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nomor_rekam_medis ?? '-' }}</td>
                                    <td>{{ $item->pendaftaran->pasien->nama }}</td>
                                    <td>{{ $item->pendaftaran->pasien->jenis_kelamin }}</td>
                                    <td>{{ $item->pendaftaran->pasien->alamat }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPasien"
                                            data-nomorrm="{{ $item->nomor_rekam_medis ?? '-' }}"
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

                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEditPasien" data-kajian_id="{{ $item->id }}"
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
                                            data-tanggal_registrasi="{{ $item->pendaftaran->tanggal_registrasi }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada pasien dengan kajian awal.
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
                        <label for="detail_nomorrm" class="form-label">Nomor Rekam Medis</label>
                        <input type="text" id="detail_nomorrm" class="form-control" readonly>
                    </div>
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

    <!-- Modal Edit Pasien -->
    <div class="modal fade" id="modalEditPasien" tabindex="-1" aria-labelledby="modalEditPasienLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditPasienLabel">Edit Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditPasien" method="POST" action="{{ route('dokter.datapasien.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="kajian_id" id="edit_kajian_id">

                        {{-- DATA DIRI --}}
                        <h5 class="text-center fs-4 fw-bold mb-4 text-primary">DATA DIRI</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama" class="form-label">Nama Pasien *</label>
                                <input type="text" id="edit_nama" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nik" class="form-label">NIK *</label>
                                <input type="text" id="edit_nik" name="nik" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tempat_lahir" class="form-label">Tempat Lahir *</label>
                                <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir *</label>
                                <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                                <select id="edit_jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_agama" class="form-label">Agama *</label>
                                <select id="edit_agama" name="agama" class="form-control" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_ayah" class="form-label">Nama Ayah *</label>
                                <input type="text" id="edit_nama_ayah" name="nama_ayah" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_ibu" class="form-label">Nama Ibu *</label>
                                <input type="text" id="edit_nama_ibu" name="nama_ibu" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat *</label>
                            <textarea id="edit_alamat" name="alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_pendidikan" class="form-label">Pendidikan *</label>
                                <select id="edit_pendidikan" name="pendidikan" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih pendidikan</option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Sarjana">Sarjana</option>
                                    <option value="Pascasarjana">Pascasarjana</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_pekerjaan" class="form-label">Pekerjaan *</label>
                                <select id="edit_pekerjaan" name="pekerjaan" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih pekerjaan</option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Guru">Guru</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_status" class="form-label">Status *</label>
                                <select id="edit_status" name="status" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>
                        </div>

                        {{-- PENANGGUNG JAWAB --}}
                        <h5 class="text-center fs-4 fw-bold mt-5 mb-4 text-success">PENANGGUNG JAWAB</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_penanggung_hubungan" class="form-label">Hubungan Keluarga *</label>
                                <select id="edit_penanggung_hubungan" name="penanggung_hubungan" class="form-control"
                                    required>
                                    <option value="" disabled selected hidden>Pilih hubungan</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_penanggung_nama" class="form-label">Nama Penanggung Jawab *</label>
                                <input type="text" id="edit_penanggung_nama" name="penanggung_nama"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_penanggung_alamat" class="form-label">Alamat Penanggung Jawab *</label>
                            <textarea id="edit_penanggung_alamat" name="penanggung_alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_penanggung_pekerjaan" class="form-label">Pekerjaan *</label>
                                <select id="edit_penanggung_pekerjaan" name="penanggung_pekerjaan" class="form-control"
                                    required>
                                    <option value="" disabled selected hidden>Pilih pekerjaan</option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Guru">Guru</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_penanggung_gender" class="form-label">Jenis Kelamin *</label>
                                <select id="edit_penanggung_gender" name="penanggung_gender" class="form-control"
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_penanggung_agama" class="form-label">Agama *</label>
                                <select id="edit_penanggung_agama" name="penanggung_agama" class="form-control" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_penanggung_status" class="form-label">Status *</label>
                                <select id="edit_penanggung_status" name="penanggung_status" class="form-control"
                                    required>
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_no_whatsapp" class="form-label">No. WhatsApp *</label>
                                <input type="text" id="edit_no_whatsapp" name="no_whatsapp" class="form-control"
                                    required>
                            </div>
                        </div>

                        {{-- JADWAL DOKTER --}}
                        <h5 class="text-center fs-4 fw-bold mt-5 mb-4 text-info">JADWAL DOKTER</h5>

                        <div class="mb-3">
                            <label for="edit_tanggal_registrasi" class="form-label">Tanggal Registrasi *</label>
                            <input type="date" id="edit_tanggal_registrasi" name="tanggal_registrasi"
                                class="form-control" required>
                        </div>

                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Data Poli, Dokter, dan Jam
                                Praktek tidak dapat diubah karena sudah terkait dengan sistem pendaftaran.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update Data Pasien</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalKonfirmasiHapusLabel">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data pasien <strong id="namaDataHapus"></strong>?</p>
                    <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="formHapus" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $kajianAwals->links() }}
    </div>

@endsection
