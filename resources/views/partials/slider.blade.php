@php
$sliderImages = ['tempat3.jpg','klinik1.jpg','tempat2.jpg', 'tempat4.jpg'];
@endphp

@foreach($sliderImages as $image)
  <div class="slider-item" style="background-image: url('{{ asset("assets/images/$image") }}');">
    <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center" data-scrollax-parent="true">
            <div class="col-md-6 col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Selamat Datang Di Klinik Pratama Aisyiyah Hj Mafroh</h1>
              <p class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Sehat Seutuhnya Sehat Selamanya</p>
              <p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><a href="/perhatian" class="btn btn-primary px-4 py-3">Daftar Online</a></p>
            </div>
          </div>
        </div>
  </div>
@endforeach
