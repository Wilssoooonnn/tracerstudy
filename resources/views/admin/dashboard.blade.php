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
                            <h4>Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi dengan Infokom</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="sebaran">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun Lulus</th>
                                            <th>Jumlah Lulusan</th>
                                            <th>Jumlah Terlacak</th>
                                            <th>Kerja Infokom</th>
                                            <th>Kerja Non Infokom</th>
                                            <th>Multinasional</th>
                                            <th>Nasional</th>
                                            <th>Wirausaha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->tahun_lulus }}</td>
                                            <td>{{ $row->jumlah_lulusan }}</td>
                                            <td>{{ $row->jumlah_terlacak }}</td>
                                            <td>{{ $row->kerja_infokom }}</td>
                                            <td>{{ $row->kerja_non_infokom }}</td>
                                            <td>{{ $row->multinasional }}</td>
                                            <td>{{ $row->nasional }}</td>
                                            <td>{{ $row->wirausaha }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="fw-bold">
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{{ $result->sum('jumlah_lulusan') }}</td>
                                            <td>{{ $result->sum('jumlah_terlacak') }}</td>
                                            <td>{{ $result->sum('kerja_infokom') }}</td>
                                            <td>{{ $result->sum('kerja_non_infokom') }}</td>
                                            <td>{{ $result->sum('multinasional') }}</td>
                                            <td>{{ $result->sum('nasional') }}</td>
                                            <td>{{ $result->sum('wirausaha') }}</td>
                                        </tr>
                                    </tfoot>
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
                                <table class="table-striped table" id="masaTunggu">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Jumlah Lulusan</th>
                                            <th>Jumlah Lulusan yang Terlacak</th>
                                            <th>Rata Rata Waktu Masa Tunggu (bulan)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tunggu_result as $i => $row)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $row->tahun }}</td>
                                                <td>{{ $row->jumlah_lulusan }}</td>
                                                <td>{{ $row->jumlah_terlacak }}</td>
                                                <td>{{ $row->rata_tunggu }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="fw-bold">
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{{ $result->sum('jumlah_lulusan') }}</td>
                                            <td>{{ $result->sum('jumlah_terlacak') }}</td>
                                            <td>{{ round($result->avg('rata_tunggu')) }}</td>
                                        </tr>
                                    </tfoot>
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
                                <table class="table-striped table" id="data">
                                    @php
                                        $total_sangat_kurang = 0;
                                        $total_kurang = 0;
                                        $total_cukup = 0;
                                        $total_baik = 0;
                                        $total_sangat_baik = 0;
                                        $jumlah_pertanyaan = count($survei);
                                    @endphp

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pertanyaan</th>
                                            <th>Sangat Kurang</th>
                                            <th>Kurang</th>
                                            <th>Cukup</th>
                                            <th>Baik</th>
                                            <th>Sangat Baik</th>
                                        </tr>
                                    </thead>

                                    @foreach ($survei as $i => $row)
                                        @php
                                            $total_per_pertanyaan = $row->sangat_kurang + $row->kurang + $row->cukup + $row->baik + $row->sangat_baik;

                                            $sk = $total_per_pertanyaan ? number_format(($row->sangat_kurang / $total_per_pertanyaan) * 100, 2) : 0;
                                            $k  = $total_per_pertanyaan ? number_format(($row->kurang / $total_per_pertanyaan) * 100, 2) : 0;
                                            $c  = $total_per_pertanyaan ? number_format(($row->cukup / $total_per_pertanyaan) * 100, 2) : 0;
                                            $b  = $total_per_pertanyaan ? number_format(($row->baik / $total_per_pertanyaan) * 100, 2) : 0;
                                            $sb = $total_per_pertanyaan ? number_format(($row->sangat_baik / $total_per_pertanyaan) * 100, 2) : 0;

                                            $total_sangat_kurang += $row->sangat_kurang;
                                            $total_kurang += $row->kurang;
                                            $total_cukup += $row->cukup;
                                            $total_baik += $row->baik;
                                            $total_sangat_baik += $row->sangat_baik;
                                        @endphp

                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $row->pertanyaan }}</td>
                                            <td>{{ $sk }}%</td>
                                            <td>{{ $k }}%</td>
                                            <td>{{ $c }}%</td>
                                            <td>{{ $b }}%</td>
                                            <td>{{ $sb }}%</td>
                                        </tr>
                                    @endforeach

                                    @php
                                        // Hitung rata-rata per kategori
                                        $avg_sk = $jumlah_pertanyaan ? number_format($total_sangat_kurang / $jumlah_pertanyaan * 100, 2) : 0;
                                        $avg_k  = $jumlah_pertanyaan ? number_format($total_kurang / $jumlah_pertanyaan * 100, 2) : 0;
                                        $avg_c  = $jumlah_pertanyaan ? number_format($total_cukup / $jumlah_pertanyaan * 100, 2) : 0;
                                        $avg_b  = $jumlah_pertanyaan ? number_format($total_baik / $jumlah_pertanyaan* 100, 2) : 0;
                                        $avg_sb = $jumlah_pertanyaan ? number_format($total_sangat_baik / $jumlah_pertanyaan * 100, 2) : 0;
                                    @endphp

                                    <tr class="fw-bold">
                                        <td></td>
                                        <td>Jumlah</td>
                                        <td>{{ $avg_sk }}%</td>
                                        <td>{{ $avg_k }}%</td>
                                        <td>{{ $avg_c }}%</td>
                                        <td>{{ $avg_b }}%</td>
                                        <td>{{ $avg_sb }}%</td>
                                    </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@1.0.0"></script>
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
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('chart.topProfesi') }}")
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.profesi);
                const values = data.map(item => item.jumlah);

                const ctx = document.getElementById("myChart1").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#FFD5E5', '#AD88C6', '#B4E4FF', '#A5D6A7', '#F7B5CA'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                formatter: (value, context) => {
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    return ((value / total) * 100).toFixed(1) + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });

            // Chart untuk Data Jenis Instansi (myChart2)
                fetch("{{ route('chart.jenisInstansi') }}")
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.instansi_nama);
                        const values = data.map(item => item.jumlah);
                        const ctx = document.getElementById("myChart2").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#FF8A80', '#FFD180', '#A5D6A7', '#B39DDB'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            datalabels: {
                                formatter: (value, context) => {
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    return ((value / total) * 100).toFixed(1) + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
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
