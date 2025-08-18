{{-- resources/views/buktipendaftaran.blade.php --}}
@extends('layouts.main')

@section('title', 'Bukti Pendaftaran - Klinik Pratama Aisyiyah Hj Mafroh')

@section('content')
<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-10">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h3 class="mb-3">Bukti Pendaftaran</h3>
            <p class="text-muted mb-4">
              Masukkan <strong>Kode/No. Pendaftaran</strong> untuk menampilkan bukti dan mencetaknya.
            </p>

            {{-- Form pencarian --}}
            <form action="#" method="GET" class="mb-4">
              <div class="form-row">
                <div class="col-md-8 mb-2">
                  <input type="text" class="form-control" placeholder="Contoh: REG-2025-000123" required>
                </div>
                <div class="col-md-4 mb-2">
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-search mr-1"></i> Cek Bukti
                  </button>
                </div>
              </div>
            </form>

            {{-- Tampilan bukti pendaftaran contoh --}}
            <div id="print-area" class="border rounded p-3">
              <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('assets/images/klinik.png') }}" alt="logo" style="height:60px" class="mr-3">
                <div>
                  <h5 class="mb-0">Klinik Pratama Aisyiyah Hj Mafroh</h5>
                  <small class="text-muted">Bukti Pendaftaran Pasien</small>
                </div>
                <div class="ml-auto text-right">
                  <span class="badge badge-info p-2">Kode: REG-2025-000123</span>
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-7">
                  <dl class="row mb-0">
                    <dt class="col-5">Nama Pasien</dt>
                    <dd class="col-7">: Budi Santoso</dd>

                    <dt class="col-5">NIK</dt>
                    <dd class="col-7">: 3275xxxxxxxxxxxx</dd>

                    <dt class="col-5">Tanggal Kunjungan</dt>
                    <dd class="col-7">: 15 Agustus 2025</dd>

                    <dt class="col-5">Poli / Layanan</dt>
                    <dd class="col-7">: Poli Umum</dd>

                    <dt class="col-5">Dokter</dt>
                    <dd class="col-7">: dr. Andi Wijaya</dd>

                    <dt class="col-5">Nomor Antrian</dt>
                    <dd class="col-7">: <strong class="h5 mb-0">A-012</strong></dd>

                    <dt class="col-5">Waktu Daftar</dt>
                    <dd class="col-7">: 15 Agustus 2025 08:15</dd>
                  </dl>
                </div>

                <div class="col-md-5 text-center">
                  <div class="border rounded d-flex align-items-center justify-content-center mb-2" style="height:160px">
                    <small class="text-muted">[QR Code]</small>
                  </div>
                  <div class="mt-2">
                    <small class="text-muted d-block">Tunjukkan bukti ini saat registrasi ulang.</small>
                  </div>
                </div>
              </div>

              <hr>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                  Catatan: Datang 10–15 menit lebih awal untuk proses verifikasi.
                </small>
                <div>
                  <button class="btn btn-outline-secondary" onclick="window.print()">
                    <i class="fa fa-print mr-1"></i> Cetak
                  </button>
                  <button class="btn btn-success">
                    <i class="fa fa-download mr-1"></i> Unduh PDF
                  </button>
                </div>
              </div>
            </div>
            {{-- Akhir bukti pendaftaran --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
