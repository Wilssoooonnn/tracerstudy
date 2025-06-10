@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">

    <style>
        thead th {
            text-align: center !important;
            vertical-align: middle !important;
            background-color: #dbeafe !important;
            /* warna biru lembut */
            color: #1e3a8a;
            /* teks biru gelap */
        }

        td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endpush

@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pekerjaan Alumni</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Jenis Instansi</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Rata Rata Masa Tunggu</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>Tahun </th>
                                            <th>Jumlah Lulusan </th>
                                            <th>Jumlah Lulusan yang Terlacak</th>
                                            <th>Profesi Kerja Bidang Infokom</th>
                                            <th>Profesi Kerja Bidang Non Infokom</th>
                                            <th>Multinasional / Internasional</th>
                                            <th>Nasional</th>
                                            <th>Wirausaha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>2021</td>
                                            <td>213</td>
                                            <td>64</td>
                                            <td>46</td>
                                            <td>18</td>
                                            <td>0</td>
                                            <td>63</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                2
                                            </td>
                                            <td>2022</td>
                                            <td>188</td>
                                            <td>34</td>
                                            <td>27</td>
                                            <td>89</td>
                                            <td>1</td>
                                            <td>36</td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                3
                                            </td>
                                            <td>2023</td>
                                            <td>200</td>
                                            <td>34</td>
                                            <td>76</td>
                                            <td>28</td>
                                            <td>5</td>
                                            <td>13</td>
                                            <td>5</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                4
                                            </td>
                                            <td>2024</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>58</td>
                                            <td>3</td>
                                            <td>23</td>
                                            <td>9</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Rata Rata Masa Tunggu</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>Tahun </th>
                                            <th>Jumlah Lulusan </th>
                                            <th>Jumlah Lulusan yang Terlacak</th>
                                            <th>Rata Rata Waktu Masa Tunggu (bulan)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>2021</td>
                                            <td>213</td>
                                            <td>64</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                2
                                            </td>
                                            <td>2022</td>
                                            <td>188</td>
                                            <td>34</td>
                                            <td>27</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                3
                                            </td>
                                            <td>2023</td>
                                            <td>200</td>
                                            <td>34</td>
                                            <td>76</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                4
                                            </td>
                                            <td>2024</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Penilaian Kepuasan Pengguna Lulusan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-3">
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Jenis Kemampuan </th>
                                        <th>Sangat Baik</th>
                                        <th>Baik</th>
                                        <th>Cukup</th>
                                        <th>Kurang</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>Kerja Sama Tim</td>
                                            <td>213</td>
                                            <td>64</td>
                                            <td>46</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                2
                                            </td>
                                            <td>Keahlian Bidang IT</td>
                                            <td>188</td>
                                            <td>34</td>
                                            <td>27</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                3
                                            </td>
                                            <td>Kemampuan Berbahasa Asing (Inggris) </td>
                                            <td>200</td>
                                            <td>34</td>
                                            <td>76</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                4
                                            </td>
                                            <td>Kemampuan Berkomunikasi</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5
                                            </td>
                                            <td>Pengembangan Diri</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                6
                                            </td>
                                            <td>Etos Kerja</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                        </tr>
                                        <tr>
                                            <td>

                                            </td>
                                            <td>Jumlah</td>
                                            <td>212</td>
                                            <td>61</td>
                                            <td>16</td>
                                            <td>46</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                    "loop": false,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": 1,
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    }
                    }
                </script>

                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Kerja Sama Tim</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Kerja"></canvas></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Keahlian Bidang TI</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Keahlian"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Kemampuan Berbahasa Asing</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Kemampuan"></canvas></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Kemampuan Berkomunikasi</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Berkomunikasi"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Pengembangan Diri</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Pengembangan"></canvas></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Kepemimpinan</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Kepemimpinan"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- slide 4 --}}
                    <div class="swiper-slide">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Etos Kerja</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Etos"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- pagination -->
                    <div class="swiper-pagination mt-3"></div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    {{-- js untuk pie chart --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart untuk Data Pekerjaan Alumni (myChart1)
            fetch("{{ route('chart.topProfesi') }}")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.profesi);
                    const values = data.map(item => item.jumlah);

                    const backgroundColors = [
                        '#FFD5E5', '#AD88C6', '#B4E4FF', '#A5D6A7', '#F7B5CA',
                        '#F5E8C7', '#EEC759', '#AB886D', '#CD5656', '#B0DB9C',
                        '#B4E4FF'
                    ];

                    var ctx = document.getElementById("myChart1").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Lulusan',
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'bottom'
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data chart untuk profesi:', error);
                });

            // Chart untuk Data Jenis Instansi (myChart2)
            fetch("{{ route('chart.jenisInstansi') }}")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.instansi_nama);
                    const values = data.map(item => item.jumlah);

                    const backgroundColors = [
                        '#FF8A80', // Perguruan Tinggi
                        '#FFD180', // Instansi Pemerintah
                        '#A5D6A7', // Perusahaan Swasta
                        '#B39DDB' // BUMN
                    ];

                    var ctx = document.getElementById("myChart2").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jenis Instansi',
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'bottom'
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data chart untuk Jenis Instansi:', error);
                });
        });

        // Jalankan saat seluruh DOM telah dimuat
        document.addEventListener("DOMContentLoaded", function() {
                    // Tempat menyimpan data chart dari backend
                    let chartData = [];

                    // Menandai chart yang sudah dirender agar tidak dirender ulang
                    let chartsRendered = {};

                    // Fetch data dari route Laravel yang mengembalikan JSON chart
                    fetch("{{ route('chart.penilaianKepuasan') }}")
                        .then(res => res.json()) // Ubah response ke format JSON
                        .then(data => {
                                chartData = data; // Simpan data chart ke variabel

                                // Untuk setiap elemen swiper di halaman
                                document.querySelectorAll('.init-swiper').forEach((el) => {
                                            // Ambil konfigurasi swiper dari elemen tersembunyi (biasanya <script type="application/json">)
                const config = JSON.parse(el.querySelector('.swiper-config').textContent);

                // Simpan event asli (jika ada) dari konfigurasi
                const originalOn = config.on || {};

                // Tambahkan fungsi render chart ke dalam event swiper
                config.on = {
                    ...originalOn,
    
                // Saat pertama kali inisialisasi swiper
                init: function () {
                    // Tunggu sedikit agar DOM canvas benar-benar ter-render
                    setTimeout(() => {
                        renderVisibleCharts(); // Panggil render chart pertama
                    }, 300); // jeda 300ms (bisa kamu atur jadi 500 jika perlu)
                },

                // Saat slide digeser dan transisi selesai
                slideChangeTransitionEnd: function () {
                    renderVisibleCharts();
                }
                };

                // Inisialisasi swiper dengan konfigurasi yang sudah dimodifikasi
                new Swiper(el, config);
            });
        });

    // Fungsi untuk menampilkan chart pada canvas yang terlihat (slide aktif)
    function renderVisibleCharts() {
        // Ambil semua canvas di slide yang sedang aktif
        document.querySelectorAll('.swiper-slide-active canvas').forEach(canvas => {
            const canvasId = canvas.id;

            // Cari data chart yang sesuai dengan canvas_id dari data backend
            const item = chartData.find(d => d.canvas_id === canvasId);

            // Jika data ada dan belum pernah dirender
            if (item && !chartsRendered[canvasId]) {
                const ctx = canvas.getContext('2d'); // Ambil context 2D canvas

                // Buat chart pie dengan Chart.js
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Sangat Kurang", "Kurang", "Cukup", "Baik", "Sangat Baik"], // Label pie chart
                        datasets: [{
                            data: item.data, // Data jumlah responden per skala
                            backgroundColor: ['#fc544b', '#ffa426', '#63ed7a', '#6777ef', '#191d21'] // Warna tiap sektor
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: item.label // Judul chart dari pertanyaan
                            },
                            legend: {
                                position: 'bottom' // Posisi legenda chart
                            }
                        }
                    }
                });

                // Tandai chart ini sudah dirender
                chartsRendered[canvasId] = true;
            }
        });
    }
});
    </script>
                                        @endpush

