
<div class="container" data-aos="fade-up" data-aos-delay="100">
  <div class="row gy-5 justify-content-center">
    <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
      <!-- Form Lulusan -->
      <div class="service-item">
          <div class="img">
            <img src=" {{ asset('dewi/assets/img/lulusan2.jpeg')}} " class="img-fluid" alt="">
          </div>
          <div class="details position-relative">
            <div class="icon">
              <i class="bi bi-person-fill"></i>
            </div>
            <a href="{{ url('lulusan/cek-nim') }}" class="stretched-link">
              <h3>Form Lulusan</h3>
            </a>
            <p>Form ini digunakan oleh lulusan untuk mengisi data terkait pekerjaan, 
            studi lanjut, dan pengalaman setelah lulus sebagai bagian dari tracer study.</p>
          </div>
        </div>
    </div>
    <div class="col-md-4">
      <!-- Form Instansi -->
       <div class="service-item">
          <div class="img">
            <img src=" {{ asset('dewi/assets/img/boss2.jpeg') }}" class="img-fluid" alt="">
          </div>
          <div class="details position-relative">
            <div class="icon">
              <i class="bi bi-person-lines-fill"></i>
            </div>
            <a href="{{ route('instansi.cek-lulusan') }}" class="stretched-link">
              <h3>Form Instansi </h3>
            </a>
            <p>Form ini diisi oleh pihak perusahaan atau instansi untuk memberikan penilaian dan masukan terhadap lulusan.</p>
          </div>
        </div>
    </div>
  </div>
</div>
