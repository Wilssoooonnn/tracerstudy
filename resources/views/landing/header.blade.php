<div class="container-fluid container-xl position-relative d-flex align-items-center">
  <a href="index.html" class="logo d-flex align-items-center me-auto text-decoration-none">
    <!-- Logo di kiri -->
    <img src="img/Logo_Jti.png" alt="Logo JTI" style="height: 50px; margin-right: 10px;">
  
    <!-- Teks di kanan -->
    <div class="d-flex flex-column">
      <h1 class="sitename mb-0 text-white fw-bold" style="font-size: 28px;">Tracer Study</h1>
      <small class="text-light fw-semibold" style="font-size: 13px;">Jurusan Teknologi Informasi</small>
    </div>
  </a>

  <nav id="navmenu" class="navmenu">
    <ul>
      <li><a href="#hero" class="active">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#graphics">Graphics</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#testimonials">Testimonial</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </nav>

  <!-- Tombol untuk buka modal -->
  <a href="{{ route('admin.login') }}" class="btn btn-outline-light mx-4">Login</a>
</div>