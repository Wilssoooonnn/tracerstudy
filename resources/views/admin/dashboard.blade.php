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
                                            <h4>Etos Kerja</h4>
                                        </div>
                                        <div class="card-body"><canvas id="Etos"></canvas></div>
                                    </div>
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
                        '#FFAB91', '#81D4FA', '#9BB0C1', '#88AB8E', '#6096B4',
                        '#A5B68D', '#EEC759', '#AB886D', '#CD5656', '#B0DB9C',
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

        //pie chart Kerja Tim
        var ctx = document.getElementById("Kerja").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // pie chart Keahlian bidang TI
        var ctx = document.getElementById("Keahlian").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // pie chart Kemampuan Berbahasa Asing
        var ctx = document.getElementById("Kemampuan").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // pie chart Kemampuan Berkomunikasi
        var ctx = document.getElementById("Berkomunikasi").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // pie chart Pengembangan Diri
        var ctx = document.getElementById("Pengembangan").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // pie chart Etos Kerja
        var ctx = document.getElementById("Etos").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        80,
                        50,
                        40,
                        30,
                        100,
                    ],
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Black',
                    'Green',
                    'Yellow',
                    'Red',
                    'Blue'
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        // swiper
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.init-swiper').forEach((el) => {
                const config = JSON.parse(el.querySelector('.swiper-config').textContent);
                new Swiper(el, config);
            });
        });
    </script>
@endpush
