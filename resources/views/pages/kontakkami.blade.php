@extends('layouts.main')

@section('title', 'Kontak Kami - Klinik Pratama Aisyiyah')
@section('content')

    <section class="home-slider owl-carousel">
      <div class="slider-item bread-item" style="background-image: url('assets/images/tempat2.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container" data-scrollax-parent="true">
          <div class="row slider-text align-items-end">
            <div class="col-md-7 col-sm-12 ftco-animate mb-5">
              <p class="breadcrumbs" data-scrollax=" properties: { translateY: '70%', opacity: 1.6}"><span class="mr-2"><a href="/">Home</a></span> <span class="mr-2"><a href="/contact">Kontak Kami</a></span></p>
              <h1 class="mb-3" data-scrollax=" properties: { translateY: '70%', opacity: .9}">Kontak Kami</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
  <div class="col-md-12 mb-4">
    <h2 class="h4">Informasi Kontak</h2>
    <p class="mb-4">Silakan hubungi kami untuk informasi layanan, pendaftaran pasien, atau konsultasi kesehatan. Tim kami siap melayani Anda dengan ramah dan profesional.</p>
  </div>
  
  <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center bg-light rounded shadow-sm w-100">
      <div class="icon d-flex align-items-center justify-content-center mb-3">
        <span class="fa fa-map-marker fa-2x text-primary"></span>
      </div>
      <h5 class="mb-2">Alamat</h5>
      <p>Jl. Pancasila No.35, RT.11/RW.04, Grogol, Kec. Dukuhturi, Kab. Tegal, Jawa Tengah 52192</p>
    </div>
  </div>

  <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center bg-light rounded shadow-sm w-100">
      <div class="icon d-flex align-items-center justify-content-center mb-3">
        <span class="fa fa-phone fa-2x text-success"></span>
      </div>
      <h5 class="mb-2">Telepon / WA</h5>
      <p><a href="https://wa.me/6285329716127" target="_blank">0853-2971-6127</a></p>
    </div>
  </div>

  <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center bg-light rounded shadow-sm w-100">
      <div class="icon d-flex align-items-center justify-content-center mb-3">
        <span class="fa fa-envelope fa-2x text-danger"></span>
      </div>
      <h5 class="mb-2">Email</h5>
      <p><a href="mailto:info@klinikaisyiyahmafroh.com">info@klinikaisyiyahmafroh.com</a></p>
    </div>
  </div>

  <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center bg-light rounded shadow-sm w-100">
      <div class="icon d-flex align-items-center justify-content-center mb-3">
        <span class="fa fa-instagram fa-2x text-warning"></span>
      </div>
      <h5 class="mb-2">Instagram</h5>
      <p><a href="https://instagram.com/klinik.aisyiyah.mafroh" target="_blank">@klinik.aisyiyah.mafroh</a></p>
    </div>
  </div>
</div>

          <!-- Google Maps dengan judul dan pin -->
<div class="col-md-6 position-relative">
  <div class="bg-light p-4 rounded shadow-sm mb-3 text-center">
    <h4 class="mb-0">
      <i class="fa fa-map-pin text-danger me-2"></i> Lokasi Klinik Kami
    </h4>
  </div>
  <div class="rounded shadow-sm overflow-hidden position-relative" style="min-height: 450px;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.932123753926!2d109.1237263737905!3d-6.898721667509267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb9006b1acef9%3A0xef3a5fa2bf237902!2sKlinik%20Pratama%20Aisyiyah%20Hj.%20Mafroh!5e0!3m2!1sid!2sid!4v1747588015234!5m2!1sid!2sid" width="1000" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>

        </div>
      </div>
    </section>

    @include('layouts.footer')


  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

@endsection