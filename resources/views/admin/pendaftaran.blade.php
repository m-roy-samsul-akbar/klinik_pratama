@extends('layouts.admin')

@section('title', 'Data Pendaftaran')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <!-- Judul -->
            <h4 class="mb-0">Registrasi Pasien</h4>

            <style>
                .input-tanggal {
                    margin-right: 10px;
                    /* Spasi antara input dan Filter */
                }

                .btn-filter {
                    margin-right: 10px;
                    /* atau 10px sesuai kebutuhan */
                }

                .btn-reset {
                    margin-right: 10px;
                    /* Opsional jika ingin jarak ke button lain */
                }
            </style>

            <!-- Filter & Button -->
            <div class="form-control-group d-flex align-items-center flex-wrap">
                <form method="GET" action="{{ route('admin.pendaftaran') }}" class="d-flex align-items-center">
                    <input type="date" name="tanggal" class="form-control form-control-sm input-tanggal"
                        style="max-width: 160px;" value="{{ request('tanggal') }}">

                    <button type="submit" class="btn btn-sm btn-primary btn-filter">Filter</button>

                    <button type="button" class="btn btn-sm btn-secondary btn-reset"
                        onclick="resetTanggal()">Reset</button>
                </form>

                <a href="#" class="btn btn-primary btn-sm d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#buatRegistrasiModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Data Registrasi
                </a>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pendaftaran</h4>
                <div class="table-responsive">
                    <table id="pendaftaranTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Daftar</th>
                                <th>Jenis Kelamin</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $pendaftaran)
                                <tr>
                                    <td>{{ $loop->iteration + ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() }}
                                    </td>
                                    <td>{{ $pendaftaran->nomor_antrian }}</td>
                                    <td>{{ $pendaftaran->pasien->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_registrasi)->format('d-m-Y') }}</td>
                                    <td>{{ $pendaftaran->pasien->jenis_kelamin }}</td>
                                    <td>{{ $pendaftaran->dokter->nama }} ({{ $pendaftaran->dokter->spesialis }})</td>
                                    <td>
                                        @if ($pendaftaran->status == 'Belum Kajian Awal')
                                            <span class="badge bg-warning">{{ $pendaftaran->status }}</span>
                                        @elseif($pendaftaran->status == 'Dalam Perawatan')
                                            <span class="badge bg-info">{{ $pendaftaran->status }}</span>
                                        @elseif($pendaftaran->status == 'Tidak Hadir')
                                            <span class="badge bg-danger">{{ $pendaftaran->status }}</span>

                                        @else
                                            <span class="badge bg-success">{{ $pendaftaran->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalKajianAwal"
                                            onclick="isiDataKajianAwal('{{ $pendaftaran->pasien->nama }}', '{{ $pendaftaran->id }}')">
                                            Kajian Awal
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary"
                                            onclick="pasienTidakHadir('{{ $pendaftaran->pasien->nama }}', '{{ $pendaftaran->id }}')">
                                            Tidak Hadir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-light">
                                    <td colspan="7" class="text-center text-muted">Belum ada data pendaftaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Buat Registrasi -->
    <div class="modal fade" id="buatRegistrasiModal" tabindex="-1" aria-labelledby="buatRegistrasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="buatRegistrasiModalLabel">Buat Registrasi Pasien</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="formRegistrasi">
                        @csrf

                        <!-- Radio Button Jenis Pasien -->
                        <div class="text-center mb-4">
                            <label class="fw-bold d-block mb-2">Jenis Pendaftaran:</label>

                            <div class="d-flex justify-content-center">
                                <label class="d-inline-flex align-items-center" style="min-width: 100px;">
                                    <input type="radio" name="jenis_pasien" value="lama" checked>
                                    <span class="ms-2">Pasien Lama</span>
                                </label>

                                <label class="d-inline-flex align-items-center" style="min-width: 50px;">
                                    <input type="radio" name="jenis_pasien" value="baru">
                                    <span class="ms-2">Pasien Baru</span>
                                </label>
                            </div>
                        </div>

                        <!-- Form Pasien Lama -->
                        <div id="formPasienLama">
                            <div class="mb-3">
                                <label for="nik_lama" class="form-label">NIK</label>
                                <input type="text" name="nik_lama" id="nik_lama" class="form-control"
                                    placeholder="Masukkan NIK">
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir_lama" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir_lama" id="tanggal_lahir_lama"
                                    class="form-control">
                            </div>

                            <button type="button" class="btn btn-info mb-3" onclick="cekPasienLama()">Cek Data
                                Pasien</button>

                            <div id="infoPasienLama" style="display: none;" class="alert alert-info">
                                <strong>Data Pasien Ditemukan:</strong>
                                <div id="detailPasienLama"></div>
                            </div>

                            <h5 class="text-center fs-4 fw-bold mt-5 mb-4">JADWAL DOKTER</h5>

                            <div class="mb-3">
                                <label for="poli_lama" class="form-label">Poli</label>
                                <select name="poli_lama" id="poli_lama" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih poli</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Gigi">Gigi</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="dokter_lama" class="form-label">Nama Dokter</label>
                                <select name="dokter_lama" id="dokter_lama" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih dokter</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jam_lama" class="form-label">Jam Praktek</label>
                                <input type="text" id="jam_lama" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_registrasi_lama" class="form-label">Tanggal Registrasi</label>
                                <input type="date" name="tanggal_registrasi_lama" id="tanggal_registrasi_lama"
                                    class="form-control" required>
                            </div>
                        </div>

                        <!-- Form Pasien Baru -->
                        <div id="formPasienBaru" style="display: none;">
                            {{-- Bagian data diri pasien --}}
                            <h5 class="text-center fs-4 fw-bold mb-4">DATA DIRI</h5>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pasien</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama">
                            </div>

                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                    placeholder="Contoh: 327106xxxxxxxx">
                            </div>

                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                    placeholder="Tempat Lahir">
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki"
                                        value="Laki-laki">
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                        value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" id="nama_ayah" class="form-control"
                                    placeholder="Nama Ayah">
                            </div>

                            <div class="mb-3">
                                <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" id="nama_ibu" class="form-control"
                                    placeholder="Nama Ibu">
                            </div>

                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select name="agama" id="agama" class="form-control">
                                    <option value="" disabled selected hidden>Pilih agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <select name="pendidikan" id="pendidikan" class="form-control">
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

                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select name="pekerjaan" id="pekerjaan" class="form-control">
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

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" disabled selected hidden>Pilih status</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>

                            <h5 class="text-center fs-4 fw-bold mt-5 mb-4">PENANGGUNG JAWAB</h5>

                            <div class="mb-3">
                                <label for="penanggung_hubungan" class="form-label">Hubungan Keluarga</label>
                                <select name="penanggung_hubungan" id="penanggung_hubungan" class="form-control">
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

                            <div class="mb-3">
                                <label for="penanggung_nama" class="form-label">Nama Penanggung Jawab</label>
                                <input type="text" name="penanggung_nama" id="penanggung_nama" class="form-control"
                                    placeholder="Nama Penanggung Jawab">
                            </div>

                            <div class="mb-3">
                                <label for="penanggung_alamat" class="form-label">Alamat</label>
                                <textarea name="penanggung_alamat" id="penanggung_alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="penanggung_pekerjaan" class="form-label">Pekerjaan</label>
                                <select name="penanggung_pekerjaan" id="penanggung_pekerjaan" class="form-control">
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

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin Penanggung Jawab</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="penanggung_gender"
                                        id="penanggung_laki" value="Laki-laki">
                                    <label class="form-check-label" for="penanggung_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="penanggung_gender"
                                        id="penanggung_perempuan" value="Perempuan">
                                    <label class="form-check-label" for="penanggung_perempuan">Perempuan</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="penanggung_agama" class="form-label">Agama</label>
                                <select name="penanggung_agama" id="penanggung_agama" class="form-control">
                                    <option value="" disabled selected hidden>Pilih agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="penanggung_status" class="form-label">Status</label>
                                <select name="penanggung_status" id="penanggung_status" class="form-control">
                                    <option value="" disabled selected hidden>Pilih status</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="no_whatsapp" class="form-label">No. WhatsApp</label>
                                <input type="text" name="no_whatsapp" id="no_whatsapp" class="form-control"
                                    placeholder="Contoh: 081234567890">
                            </div>

                            <h5 class="text-center fs-4 fw-bold mt-5 mb-4">JADWAL DOKTER</h5>

                            <div class="mb-3">
                                <label for="poli_baru" class="form-label">Poli</label>
                                <select name="poli_baru" id="poli_baru" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih poli</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Gigi">Gigi</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="dokter_baru" class="form-label">Nama Dokter</label>
                                <select name="dokter_baru" id="dokter_baru" class="form-control" required>
                                    <option value="" disabled selected hidden>Pilih dokter</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jam_baru" class="form-label">Jam Praktek</label>
                                <input type="text" id="jam_baru" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_registrasi_baru" class="form-label">Tanggal Registrasi</label>
                                <input type="date" name="tanggal_registrasi" id="tanggal_registrasi_baru"
                                    class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="simpanRegistrasi()">Simpan
                        Registrasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalKajianAwal" tabindex="-1" aria-labelledby="modalKajianAwalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kajian-awal.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftaran_id" id="kajian_pendaftaran_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKajianAwalLabel">Form Kajian Awal Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                placeholder="Masukkan nama pasien" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="suhu_tubuh" class="form-label">Suhu Tubuh (°C)</label>
                                <input type="number" step="0.1" class="form-control" id="suhu_tubuh"
                                    name="suhu_tubuh" placeholder="Contoh: 36.5" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                                <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah"
                                    placeholder="Contoh: 120/80" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan"
                                    placeholder="Contoh: 170" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="berat_badan"
                                name="berat_badan" placeholder="Contoh: 65.5" required>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan Pasien</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="4"
                                placeholder="Deskripsikan keluhan pasien" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Kajian</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {!! $pendaftarans->appends(request()->query())->links() !!}
    </div>

    <script>
        function resetTanggal() {
            const input = document.querySelector('input[name="tanggal"]');
            const form = input.closest('form');
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            input.value = `${yyyy}-${mm}-${dd}`;
            form.submit(); // ⬅️ Auto submit setelah reset tanggal
        }
    </script>

    <script>

            function pasienTidakHadir(namaPasien, id) {
                if(!confirm(`Yakin ingin menandai ${namaPasien} sebagai TIDAK HADIR?`)) return;

                fetch("{{ route('pasien.tidak_hadir') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`✅ ${namaPasien} berhasil ditandai sebagai Tidak Hadir!`);
                        // bisa langsung refresh tabel realtime
                        fetchRealtimeDashboard();
                    } else {
                        alert("❌ Gagal update status pasien.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menghubungi server.");
                });
            }

    </script>


@endsection
