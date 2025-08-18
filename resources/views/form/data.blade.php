@extends('layouts.data')

@section('title', 'Verifikasi Data Pasien')

@section('header', 'Verifikasi Data')

@section('content')
    <div class="progress-bar">
        <div class="progress-step">1</div>
        <div class="progress-line"></div>
        <div class="progress-step">2</div>
        <div class="progress-line"></div>
        <div class="progress-step active">3</div>
        <div class="progress-line"></div>
        <div class="progress-step">4</div>
    </div>

    <form>
        <h3>DATA DIRI</h3>
        <div class="form-group"><label>Nama</label><input type="text" value="John Doe" readonly /></div>
        <div class="form-group"><label>NIK</label><input type="text" value="1234567890123456" readonly /></div>
        <div class="form-group"><label>Tanggal Lahir</label><input type="text" value="1990-01-01" readonly /></div>
        <div class="form-group"><label>Tempat Lahir</label><input type="text" value="Bandung" readonly /></div>
        <div class="form-group"><label>Jenis Kelamin</label><input type="text" value="Laki-Laki" readonly /></div>
        <div class="form-group"><label>No Handphone</label><input type="text" value="081234567890" readonly /></div>
        <div class="form-group"><label>Nama Ayah</label><input type="text" value="Bapak Doe" readonly /></div>
        <div class="form-group"><label>Nama Ibu</label><input type="text" value="Ibu Doe" readonly /></div>
        <div class="form-group"><label>Agama</label><input type="text" value="Islam" readonly /></div>
        <div class="form-group"><label>Alamat</label><input type="text" value="Jl. Sehat No. 10" readonly /></div>
        <div class="form-group"><label>Pendidikan</label><input type="text" value="S1" readonly /></div>

        <h3>DATA PENANGGUNG JAWAB</h3>
        <div class="form-group"><label>Hubungan Keluarga</label><input type="text" value="Ayah" readonly /></div>
        <div class="form-group"><label>Nama Penanggung Jawab</label><input type="text" value="Bapak Doe" readonly />
        </div>
        <div class="form-group"><label>Alamat</label><input type="text" value="Jl. Sehat No. 10" readonly /></div>
        <div class="form-group"><label>Pekerjaan</label><input type="text" value="Pegawai Negeri" readonly /></div>
        <div class="form-group"><label>Jenis Kelamin</label><input type="text" value="Laki-Laki" readonly /></div>
        <div class="form-group"><label>Agama</label><input type="text" value="Islam" readonly /></div>
        <div class="form-group"><label>No. Handphone</label><input type="text" value="081234567890" readonly /></div>

        <h3>DATA JADWAL DOKTER</h3>
        <div class="form-group"><label>Poliklinik</label><input type="text" value="Poli Umum" readonly /></div>
        <div class="form-group"><label>Dokter</label><input type="text" value="dr. Siti Andini" readonly /></div>
        <div class="form-group"><label>Tanggal Booking</label><input type="text" value="2025-07-10" readonly /></div>
        <div class="form-group"><label>No. Whatsapp</label><input type="text" value="081212345678" readonly /></div>

        <div class="checkbox">
            <input type="checkbox" id="agree" />
            <label for="agree">Saya setuju dengan ketentuan di atas</label>
        </div>

        <div class="buttons">
            <button type="button" class="btn btn-batal" onclick="history.back()">Batal</button>
            <button type="button" class="btn btn-lanjut" id="lanjutBtn" data-redirect="{{ route('otp') }}">
                Lanjutkan
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/data.js') }}"></script>
@endpush
