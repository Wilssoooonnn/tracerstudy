<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>JTI - Tracer Study</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('dewi/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('dewi/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Raleway:wght@300;400;600;700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('dewi/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dewi/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('dewi/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('dewi/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dewi/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('dewi/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    @include('landing.header')
  </header>

  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background position-relative">
      {{-- <video autoplay loop muted playsinline class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
        style="z-index: -1;">
        <source src="{{ asset('dewi/assets/videos/videoplayback.mp4') }}" type="video/mp4">
      </video> --}}

      <video autoplay loop muted playsinline class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
        <source src="{{ asset('dewi/assets/videos/videoplayback.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>

      <div class="container d-flex flex-column align-items-center justify-content-center text-center text-white py-5"
        style="min-height: 100vh;">
        <h2 data-aos="fade-up" data-aos-delay="100" class="display-4 fw-bold">TRACK. CONNECT. IMPROVE.</h2>
        <p data-aos="fade-up" data-aos-delay="200" class="lead">Halo, Selamat Datang di Tracer Study JTI POLINEMA! 
          <br>Melalui sistem ini, kami menjalin koneksi antara kampus, alumni, dan dunia kerja 
          untuk menciptakan pendidikan yang relevan dan berkualitas.</p>
        <div class="d-flex mt-4 gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="300">
          <a href="#about" class="btn btn-primary btn-lg px-4">Get Started</a>
        </div>
      </div>
    </section>

    <!-- Content Sections -->
    <section id="about" class="about section">@include('landing.about')</section>
    <section id="stats" class="stats section light-background">@include('landing.stats')</section>
      <section id="charts" class="charts section">
      <div class="container section-title" data-aos="fade-up">
        <h2>GRAPHIC</h2>
        <p>GRAPHIC DATA LULUSAN</p>
      </div>
    </section>
    <section id="services" class="services section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Featured Services</p>
      </div>
      @include('landing.services')
    </section>
    <section id="testimonials" class="testimonials section dark-background">@include('landing.testimonial')</section>
    {{-- <section id="portfolio" class="portfolio section">@include('landing.portofolio')</section> --}}
    <section id="team" class="team section light-background">@include('landing.team')</section>
  </main>

  <footer id="footer" class="footer dark-background">
    @include('landing.tentang')
    <div class="container text-center mt-4">
      <p class="mb-0"><span>Copyright 2025</span> &#169; <strong>Tracer Study JTI - POLINEMA</strong>. All Rights Reserved</p>
      <div class="credits">
        Designed by <a href="#">Kelompok 6</a> - SIB 2C <!-- <a href="https://themewagon.com">ThemeWagon</a> -->
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('dewi/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('dewi/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{ asset('dewi/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('dewi/assets/js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>