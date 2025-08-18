@extends('layouts.perhatian')

@section('title', 'Perhatian Registrasi Online')

@section('content')
  <!-- Halaman pertama -->
  <div class="card fade-in" id="page1">
    <div class="card-header">
      <i class="fas fa-info-circle"></i> Informasi Registrasi Online
    </div>

    <div class="card-body">
      <p>Berikut 4 Langkah mudah <strong>Registrasi Online :</strong></p>
      <ol>
        <li><strong>Verifikasi Data Pasien</strong></li>
        <li><strong>Pilih Jadwal Dokter</strong></li>
        <li><strong>Konfirmasi</strong></li>
        <li><strong>Selesai (Dapatkan Nomor Antrian dan Kode Booking)</strong></li>
      </ol>
    </div>
    <div class="card-footer">
      <button class="btn btn-secondary" onclick="history.back()">
        Kembali
      </button>
      <button class="btn btn-primary" onclick="navigateToPage2()">
        Lanjutkan
      </button>
    </div>
  </div>

  <!-- Halaman kedua -->
  <div class="terms-card" id="page2" style="display: none;">
    <div class="terms-header">Ketentuan Umum Pendaftaran Online</div>
    <div class="terms-body">
      <ol>
        <li>
          Pendaftaran Online bisa dilakukan oleh pasien yang telah memiliki
          No. Rekam Medik maupun pasien baru Umum dan JKN.
        </li>
        <li>
          Pendaftaran Online dapat dilakukan untuk kontrol Poli dengan Jadwal
          H+1 s.d H+30 dari hari mendaftar.
        </li>
        <li>
          Pasien di hari yang sama hanya dapat mendaftar 1 kali dengan 1
          dokter.
        </li>
        <li>
          Pasien yang telah mendaftar online akan mendapatkan pesan melalui
          Whatsapp berisi pemberitahuan mendapatkan Nomer Antrean.
        </li>
        <li>
          Apabila terdapat perubahan jadwal dokter maka jadwal yang telah
          dipesan tersebut akan dilayani oleh dokter lain yang bertugas.
        </li>
        <li>
          Apabila Anda telah melakukan pendaftaran online, Anda akan mendapat bukti registrasi dan nomor urut antrian.
        </li>
        <li>
          Urutan pelayanan berdasarkan nomor antri yang didapatkan pada waktu melakukan pendaftaran online. 
          Pasien yang melakukan pendaftaran onsite akan mendapatkan nomor antrian setelah pendaftaran online.
        </li>
      </ol>

      <div class="terms-checkbox">
        <input type="checkbox" id="agree-checkbox" />
        <label for="agree-checkbox">Saya setuju dengan ketentuan di atas</label>
      </div>
    </div>

    <div class="terms-footer">
      <button class="btn btn-danger" onclick="navigateToPage1()">Kembali</button>
      <button class="btn btn-primary" onclick="redirectToNewPage()">Lanjutkan</button>
    </div>
  </div>
@endsection
