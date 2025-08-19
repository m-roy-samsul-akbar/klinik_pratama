@extends('layouts.verifikasi')

@section('title', 'Verifikasi & Booking Pasien')
@section('header', 'FORMULIR VERIFIKASI & PEMILIHAN JADWAL')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pendaftaran.css') }}">
@endpush

@section('content')
    <div class="progress-bar">
        <div class="progress-step">1</div>
        <div class="progress-line"></div>
        <div class="progress-step">2</div>
        <div class="progress-line"></div>
        <div class="progress-step">3</div>
        <div class="progress-line"></div>
        <div class="progress-step">4</div>
    </div>

    <form id="formVerifikasi" method="POST" action="{{ route('registerPendaftaran.store') }}">
        @csrf

        {{-- penting untuk validasi global controller --}}
        <input type="hidden" name="tanggal_registrasi" id="tanggal_registrasi_master">

        {{-- STEP 1: DATA PASIEN --}}
        <section id="step1" class="form-step">
            <h3>DATA PASIEN</h3>

            <div class="form-group">
                <label>Jenis Pendaftaran</label>
                <div class="form-radio-group">
                    <label><input type="radio" name="jenis_pasien" value="lama"> Pasien Lama</label>
                    <label><input type="radio" name="jenis_pasien" value="baru" checked> Pasien Baru</label>
                </div>
            </div>

            {{-- PASIEN BARU --}}
            <div id="formPasienBaru" style="display:none">
                <h4 class="section-title">Data Pasien Baru</h4>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap">
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" maxlength="16" placeholder="16 digit">
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Tempat Lahir">
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label><input type="radio" name="jenis_kelamin" value="Laki-laki"> Laki-laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" placeholder="Nama Ayah">
                </div>

                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" placeholder="Nama Ibu">
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama">
                        <option value="" disabled selected hidden>Pilih agama</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat lengkap">
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan">
                        <option value="" disabled selected hidden>Pilih pendidikan</option>
                        <option>Tidak Sekolah</option>
                        <option>SD</option>
                        <option>SMP</option>
                        <option>SMA/SMK</option>
                        <option>Diploma</option>
                        <option>Sarjana</option>
                        <option>Pascasarjana</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan">
                        <option value="" disabled selected hidden>Pilih pekerjaan</option>
                        <option>Pelajar</option>
                        <option>Petani</option>
                        <option>Pedagang</option>
                        <option>Guru</option>
                        <option>PNS</option>
                        <option>Karyawan Swasta</option>
                        <option>Wirausaha</option>
                        <option>Ibu Rumah Tangga</option>
                        <option>Tidak Bekerja</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="" disabled selected hidden>Pilih status</option>
                        <option>Belum Kawin</option>
                        <option>Kawin</option>
                        <option>Cerai</option>
                    </select>
                </div>

                <h4 class="section-title">Data Penanggung Jawab</h4>

                <div class="form-group">
                    <label>Hubungan Keluarga</label>
                    <select name="penanggung_hubungan">
                        <option value="" disabled selected hidden>Pilih hubungan</option>
                        <option>Ayah</option>
                        <option>Ibu</option>
                        <option>Suami</option>
                        <option>Istri</option>
                        <option>Anak</option>
                        <option>Saudara</option>
                        <option>Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Penanggung Jawab</label>
                    <input type="text" name="penanggung_nama" placeholder="Nama Penanggung Jawab">
                </div>

                <div class="form-group">
                    <label>Alamat Penanggung</label>
                    <input type="text" name="penanggung_alamat" placeholder="Alamat">
                </div>

                <div class="form-group">
                    <label>Pekerjaan Penanggung</label>
                    <select name="penanggung_pekerjaan">
                        <option value="" disabled selected hidden>Pilih pekerjaan</option>
                        <option>Pelajar</option>
                        <option>Petani</option>
                        <option>Pedagang</option>
                        <option>Guru</option>
                        <option>PNS</option>
                        <option>Karyawan Swasta</option>
                        <option>Wirausaha</option>
                        <option>Ibu Rumah Tangga</option>
                        <option>Tidak Bekerja</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin Penanggung</label>
                    <div class="radio-group">
                        <label><input type="radio" name="penanggung_gender" value="Laki-laki"> Laki-laki</label>
                        <label><input type="radio" name="penanggung_gender" value="Perempuan"> Perempuan</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Agama Penanggung</label>
                    <select name="penanggung_agama">
                        <option value="" disabled selected hidden>Pilih agama</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Penanggung</label>
                    <select name="penanggung_status">
                        <option value="" disabled selected hidden>Pilih status</option>
                        <option>Belum Kawin</option>
                        <option>Kawin</option>
                        <option>Cerai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>No. WhatsApp</label>
                    <input type="text" name="no_whatsapp" id="no_whatsapp"
                        placeholder="Contoh: 081234567890 / 6281234567890">
                </div>
            </div>

            {{-- Pasien Lama (dengan tombol Cek Data Pasien) --}}
            <div id="formPasienLama" style="display:none">
                <h4 class="section-title">Data Pasien Lama</h4>

                <div class="form-group">
                    <label for="nik_lama">NIK</label>
                    <input type="text" name="nik_lama" id="nik_lama" placeholder="3271xxxxxxxxxxxx"
                        maxlength="16" />
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir_lama">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir_lama" id="tanggal_lahir_lama" />
                </div>

                <div class="form-group" style="margin-top:.5rem">
                    {{-- gunakan endpoint publik agar tidak kena redirect login --}}
                    <button type="button" id="btnCekPasienLama" class="btn-cek-data"
                        data-url="{{ route('api.pasien.cek') }}">
                        Cek Data Pasien
                    </button>
                </div>

                {{-- Area hasil cek --}}
                <div id="infoPasienLama" class="alert" style="display:none">
                    <div id="detailPasienLama"></div>
                </div>
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="history.back()">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(2)">Lanjutkan</button>
            </div>
        </section>

        {{-- STEP 2: PILIH JADWAL DOKTER --}}
        <section id="step2" class="form-step" style="display:none">
            <h3>PILIH JADWAL DOKTER</h3>

            {{-- Untuk Pasien Lama --}}
            <div id="blokJadwalLama" style="display:none">
                <div class="form-group">
                    <label for="poli_lama">Poli</label>
                    <select id="poli_lama" name="poli_lama">
                        <option value="" disabled selected hidden>Pilih poli</option>
                        <option value="Umum">Umum</option>
                        <option value="Gigi">Gigi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dokter_lama">Dokter</label>
                    <select id="dokter_lama" name="dokter_lama">
                        <option value="" disabled selected hidden>Pilih dokter</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jam Praktek</label>
                    <input type="text" id="jam_lama" readonly placeholder="--,--">
                </div>

                <div class="form-group">
                    <label for="tanggal_registrasi_lama">Tanggal Registrasi</label>
                    <input type="date" id="tanggal_registrasi_lama" name="tanggal_registrasi_lama">
                </div>
            </div>

            {{-- Untuk Pasien Baru --}}
            <div id="blokJadwalBaru" style="display:none">
                <div class="form-group">
                    <label for="poli_baru">Poli</label>
                    <select id="poli_baru" name="poli_baru">
                        <option value="" disabled selected hidden>Pilih poli</option>
                        <option value="Umum">Umum</option>
                        <option value="Gigi">Gigi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dokter_baru">Dokter</label>
                    <select id="dokter_baru" name="dokter_baru">
                        <option value="" disabled selected hidden>Pilih dokter</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jam Praktek</label>
                    <input type="text" id="jam_baru" readonly placeholder="--,--">
                </div>

                <div class="form-group">
                    <label for="tanggal_registrasi_baru">Tanggal Registrasi</label>
                    <input type="date" id="tanggal_registrasi_baru" name="tanggal_registrasi_baru">
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn-back" onclick="prevStep(1)">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(3)">Lanjutkan</button>
            </div>
        </section>

        {{-- STEP 3: OPSIONAL - NOTIF KODE ANTRIAN --}}
        <section id="step3" class="form-step" style="display:none">
            <h3>NOTIFIKASI KODE ANTRIAN </h3>
            <p class="text-muted step3-intro">
                Masukkan nomer whatsapp untuk mendapatkan nomer antrian.
            </p>
            <div class="form-group">
                <label for="whatsapp">Nomor WhatsApp </label>
                <input id="whatsapp" type="tel" name="whatsapp" inputmode="tel" autocomplete="tel"
                    placeholder="0812xxxxxxx atau +62812xxxxxxx" class="form-control">
                <small class="text-muted">
                    Isi nomer whatsapp untuk mendapatkan <strong>nomer antrian</strong> dan bukti pendaftaran
                </small>
            </div>

            <div class="checkbox-group checkbox-sm"
                style="margin-top:1rem; display:flex;gap:.6rem;align-items:flex-start">
                <input type="checkbox" id="consent" name="consent" value="1">
                <label for="consent">Saya menyetujui menerima pesan WhatsApp terkait kode antrian.</label>
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="prevStep(2)">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(4)">Lanjutkan</button>
            </div>
        </section>

        {{-- STEP 4: REVIEW --}}
        <section id="step4" class="form-step" style="display:none">
            <h3>REVIEW DATA & KONFIRMASI</h3>
            <p class="text-muted" style="margin-bottom:1rem">
                Periksa kembali data Anda. Jika sudah benar, tekan <strong>Kirim</strong>.
            </p>

            <div class="preview-grid">
                <div class="preview-card">
                    <h4>Data Pasien</h4>
                    <ul>
                        <li><strong>Jenis:</strong> <span data-preview="jenis_pasien"></span></li>
                        <li><strong>Nama:</strong> <span data-preview="nama"></span></li>
                        <li><strong>NIK:</strong> <span data-preview="nik"></span></li>
                        <li><strong>TTL:</strong> <span data-preview="ttl"></span></li>
                        <li><strong>Jenis Kelamin:</strong> <span data-preview="jenis_kelamin"></span></li>
                        <li><strong>Agama:</strong> <span data-preview="agama"></span></li>
                        <li><strong>Alamat:</strong> <span data-preview="alamat"></span></li>
                        <li><strong>Pendidikan:</strong> <span data-preview="pendidikan"></span></li>
                        <li><strong>Pekerjaan:</strong> <span data-preview="pekerjaan"></span></li>
                        <li><strong>Status Kawin:</strong> <span data-preview="status"></span></li>
                    </ul>
                </div>

                <div class="preview-card">
                    <h4>Penanggung Jawab</h4>
                    <ul>
                        <li><strong>Hubungan:</strong> <span data-preview="penanggung_hubungan"></span></li>
                        <li><strong>Nama:</strong> <span data-preview="penanggung_nama"></span></li>
                        <li><strong>Alamat:</strong> <span data-preview="penanggung_alamat"></span></li>
                        <li><strong>Gender:</strong> <span data-preview="penanggung_gender"></span></li>
                        <li><strong>Agama:</strong> <span data-preview="penanggung_agama"></span></li>
                        <li><strong>Pekerjaan:</strong> <span data-preview="penanggung_pekerjaan"></span></li>
                        <li><strong>Status:</strong> <span data-preview="penanggung_status"></span></li>
                        <li><strong>No. WA:</strong> <span data-preview="no_whatsapp"></span></li>
                    </ul>
                </div>

                <div class="preview-card">
                    <h4>Jadwal & Notifikasi</h4>
                    <ul>
                        <li><strong>Poli:</strong> <span data-preview="poli"></span></li>
                        <li><strong>Dokter:</strong> <span data-preview="dokter"></span></li>
                        <li><strong>Jam:</strong> <span data-preview="jam"></span></li>
                        <li><strong>Tanggal Booking:</strong> <span data-preview="tanggal_registrasi"></span></li>
                        <li><strong>WA (opsional):</strong> <span data-preview="whatsapp"></span></li>
                        <li><strong>Persetujuan WA:</strong> <span data-preview="consent"></span></li>
                    </ul>
                </div>
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="prevStep(3)">Kembali</button>
                <button type="submit" class="btn-next">Kirim</button>
            </div>
        </section>
    </form>
@endsection

@push('scripts')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JS form (sudah kita buat: assets/js/pendaftaran.js) --}}
    <script src="{{ asset('assets/js/pendaftaran.js') }}"></script>
@endpush
