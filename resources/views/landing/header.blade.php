<div class="container-fluid container-xl position-relative d-flex align-items-center">

  <a href="index.html" class="logo d-flex align-items-center me-auto">
    <!-- Uncomment the line below if you also wish to use an image logo -->
    <!-- <img src="assets/img/logo.png" alt=""> -->
    <h1 class="sitename">Tracer Study</h1>
  </a>

  <nav id="navmenu" class="navmenu">
    <ul>
      <li><a href="#hero" class="active">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      {{-- <li><a href="#portfolio">Portfolio</a></li> --}}
      <li><a href="#team">Team</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </nav>

  <!-- Tombol untuk buka modal -->
  <a href="{{ route('admin.login') }}" class="btn btn-outline-light mx-4">Login</a>
</div>