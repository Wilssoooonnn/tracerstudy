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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        thead th {
            text-align: center !important;
            vertical-align: middle !important;
            background-color: #6777ef !important;
            /* Stisla primary */
            color: #fff !important;
            font-size: 13px;
            font-weight: 600;
            padding: 14px !important;
            border-bottom: 2px solid #5a66d9 !important;
        }

        tbody td {
            vertical-align: middle !important;
            font-size: 13px;
            padding: 12px !important;
            color: #343a40;
        }

        tbody td.text-left {
            text-align: left !important;
        }

        .zero-value {
            display: inline-block;
            background-color: #fee2e2;
            color: #fc544b;
            /* Stisla danger */
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
    </style>

@endpush

@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Tracer Study</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Alumni</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalAlumni }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Admin</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalAdmin }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Stakeholder</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalStakeholder }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tracer Record</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalTracerRecord }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dropdown Filter -->
            <div class="row py-3">
                <div class="col-md-6">
                    <label>Program Studi:</label>
                    <select id="programStudiFilter" class="form-control">
                        <option value="all">Semua Program Studi</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->program_studi }}">{{ $p->program_studi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Range Tahun:</label>
                    <select id="tahunRangeFilter" class="form-control">
                        <option value="all">Semua Tahun</option>
                        @foreach($yearRanges as $range)
                            <option value="{{ $range }}">{{ $range }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <div class="col-12 col-lg-8 d-flex flex-column">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Statistics</h4>
                            <!-- Dropdown Filter for Statistics -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="statsFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih Statistik
                                </button>
                                <div class="dropdown-menu" aria-labelledby="statsFilter">
                                    <a class="dropdown-item" href="#" data-filter="all">Semua Alumni</a>
                                    <a class="dropdown-item" href="#" data-filter="tracked">Alumni Terlacak</a>
                                    <a class="dropdown-item" href="#" data-filter="untracked">Alumni Tidak Terlacak</a>
                                    <a class="dropdown-item" href="#" data-filter="infokom">Bidang Infokom</a>
                                    <a class="dropdown-item" href="#" data-filter="non_infokom">Bidang Non Infokom</a>
                                    <a class="dropdown-item" href="#" data-filter="belum_bekerja">Belum Bekerja</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Bar Chart -->
                            <canvas id="statsChart" style="max-height: 500px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex flex-column">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Alumni dan Instansi</h4>
                            <!-- Dropdown Filter for Carousel -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="chartFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih Chart
                                </button>
                                <div class="dropdown-menu" aria-labelledby="chartFilter">
                                    <a class="dropdown-item" href="#" data-slide-to="0">Data Pekerjaan Alumni</a>
                                    <a class="dropdown-item" href="#" data-slide-to="1">Data Jenis Instansi</a>
                                    <a class="dropdown-item" href="#" data-slide-to="2">Data Profesi Alumni</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Carousel for charts -->
                            <div id="chartCarousel" class="carousel slide" data-ride="false">
                                <div class="carousel-inner">
                                    <!-- First Chart: Data Pekerjaan Alumni -->
                                    <div class="carousel-item active">
                                        <canvas id="myChart1"></canvas>
                                    </div>
                                    <!-- Second Chart: Data Jenis Instansi -->
                                    <div class="carousel-item">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                    <!-- Third Chart: Data Profesi Alumni -->
                                    <div class="carousel-item">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                </div>
                                <!-- Carousel controls -->
                                <a class="carousel-control-prev" href="#chartCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#chartCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Sebaran Data Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi</h4>
                            <!-- Filter Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sebaranFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter Data
                                </button>
                                <div class="dropdown-menu" aria-labelledby="sebaranFilter">
                                    <a class="dropdown-item sebaran-filter" href="#" data-filter="all">Semua Data</a>
                                    <a class="dropdown-item sebaran-filter" href="#" data-filter="infokom">Kerja Infokom</a>
                                    <a class="dropdown-item sebaran-filter" href="#" data-filter="non_infokom">Kerja Non
                                        Infokom</a>
                                    <a class="dropdown-item sebaran-filter" href="#"
                                        data-filter="international">Instansi</a>
                                    <a class="dropdown-item sebaran-filter" href="#" data-filter="recent">Tahun 2025+</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" id="sebaran">
                                    <thead>
                                        <tr>
                                            <th data-toggle="tooltip" title="Nomor Urut">No</th>
                                            <th data-toggle="tooltip" title="Tahun Kelulusan">Thn. Lulus</th>
                                            <th data-toggle="tooltip" title="Jumlah Total Lulusan">Jml. Lulusan</th>
                                            <th data-toggle="tooltip" title="Jumlah Lulusan yang Terlacak">Jml. Terlacak
                                            </th>
                                            <th data-toggle="tooltip" title="Bekerja di Bidang Infokom">Kerja Infokom</th>
                                            <th data-toggle="tooltip" title="Bekerja di Bidang Non Infokom">Kerja Non
                                                Infokom</th>
                                            <th data-toggle="tooltip" title="Bekerja di Instansi Internasional">
                                                International</th>
                                            <th data-toggle="tooltip" title="Bekerja di Instansi Nasional">Nasional</th>
                                            <th data-toggle="tooltip" title="Berwirausaha">Wirausaha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row->tahun_lulus }}</td>
                                                <td>{{ $row->jumlah_lulusan }}</td>
                                                <td>{{ $row->jumlah_lulusan }}</td>
                                                <td>{!! $row->kerja_infokom == 0 ? '<span class="zero-value">0</span>' : $row->kerja_infokom !!}
                                                </td>
                                                <td>{!! $row->kerja_non_infokom == 0 ? '<span class="zero-value">0</span>' : $row->kerja_non_infokom !!}
                                                </td>
                                                <td>{!! $row->international == 0 ? '<span class="zero-value">0</span>' : ($row->international ?? '-') !!}
                                                </td>
                                                <td>{!! $row->nasional == 0 ? '<span class="zero-value">0</span>' : ($row->nasional ?? '-') !!}
                                                </td>
                                                <td>{!! $row->wirausaha == null ? '<span class="zero-value">-</span>' : ($row->wirausaha == 0 ? '<span class="zero-value">0</span>' : $row->wirausaha) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{{ $result->sum('jumlah_lulusan') }}</td>
                                            <td>{{ $result->sum('jumlah_lulusan') }}</td>
                                            <td>{!! $result->sum('kerja_infokom') == 0 ? '<span class="zero-value">0</span>' : $result->sum('kerja_infokom') !!}
                                            </td>
                                            <td>{!! $result->sum('kerja_non_infokom') == 0 ? '<span class="zero-value">0</span>' : $result->sum('kerja_non_infokom') !!}
                                            </td>
                                            <td>{!! $result->sum('international') == 0 ? '<span class="zero-value">0</span>' : ($result->sum('international') ?? '-') !!}
                                            </td>
                                            <td>{!! $result->sum('nasional') == 0 ? '<span class="zero-value">0</span>' : ($result->sum('nasional') ?? '-') !!}
                                            </td>
                                            <td>{!! $result->sum('wirausaha') == null ? '<span class="zero-value">-</span>' : ($result->sum('wirausaha') == 0 ? '<span class="zero-value">0</span>' : $result->sum('wirausaha')) !!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Masa Tunggu Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Rata-Rata Masa Tunggu</h4>
                            <!-- Filter Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="tungguFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter Data
                                </button>
                                <div class="dropdown-menu" aria-labelledby="tungguFilter">
                                    <a class="dropdown-item tunggu-filter" href="#" data-filter="all">Semua Data</a>
                                    <a class="dropdown-item tunggu-filter" href="#" data-filter="recent">Tahun 2025+</a>
                                    <a class="dropdown-item tunggu-filter" href="#" data-filter="has_tunggu">Masa Tunggu >
                                        0</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" id="masaTunggu">
                                    <thead>
                                        <tr>
                                            <th data-toggle="tooltip" title="Nomor Urut">No</th>
                                            <th data-toggle="tooltip" title="Tahun Kelulusan">Tahun</th>
                                            <th data-toggle="tooltip" title="Jumlah Total Lulusan">Jml. Lulusan</th>
                                            <th data-toggle="tooltip" title="Jumlah Lulusan yang Terlacak">Jml. Terlacak
                                            </th>
                                            <th data-toggle="tooltip" title="Rata-Rata Masa Tunggu dalam Bulan">Rata-Rata
                                                Tunggu (bln)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tunggu_result as $i => $row)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $row->tahun }}</td>
                                                <td>{{ $row->jumlah_lulusan }}</td>
                                                <td>{{ $row->jumlah_lulusan }}</td>
                                                <td>{!! $row->rata_tunggu == 0 ? '<span class="zero-value">0</span>' : number_format($row->rata_tunggu, 2) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{{ $tunggu_result->sum('jumlah_lulusan') }}</td>
                                            <td>{{ $tunggu_result->sum('jumlah_lulusan') }}</td>
                                            <td>{!! $tunggu_result->avg('rata_tunggu') == 0 ? '<span class="zero-value">0</span>' : number_format($tunggu_result->avg('rata_tunggu'), 2) !!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survei Kepuasan Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Penilaian Kepuasan Pengguna Lulusan</h4>
                            <!-- Filter Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="surveiFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter Data
                                </button>
                                <div class="dropdown-menu" aria-labelledby="surveiFilter">
                                    <a class="dropdown-item survei-filter" href="#" data-filter="all">Semua Data</a>
                                    <a class="dropdown-item survei-filter" href="#" data-filter="has_responses">Pertanyaan
                                        dengan Respon</a>
                                    <a class="dropdown-item survei-filter" href="#" data-filter="high_satisfaction">Kepuasan
                                        Tinggi</a>
                                    <a class="dropdown-item survei-filter" href="#" data-filter="low_satisfaction">Kepuasan
                                        Rendah</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" id="data">
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
                                            <th data-toggle="tooltip" title="Nomor Urut">No</th>
                                            <th data-toggle="tooltip" title="Pertanyaan Survei">Pertanyaan</th>
                                            <th data-toggle="tooltip" title="Persentase Respon Sangat Kurang">Sgt. Kurang
                                                (%)</th>
                                            <th data-toggle="tooltip" title="Persentase Respon Kurang">Kurang (%)</th>
                                            <th data-toggle="tooltip" title="Persentase Respon Cukup">Cukup (%)</th>
                                            <th data-toggle="tooltip" title="Persentase Respon Baik">Baik (%)</th>
                                            <th data-toggle="tooltip" title="Persentase Respon Sangat Baik">Sgt. Baik (%)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($survei as $i => $row)
                                            @php
                                                $total_responses = $row->sangat_kurang + $row->kurang + $row->cukup + $row->baik + $row->sangat_baik;
                                                $pct_sangat_kurang = $total_responses > 0 ? ($row->sangat_kurang / $total_responses * 100) : 0;
                                                $pct_kurang = $total_responses > 0 ? ($row->kurang / $total_responses * 100) : 0;
                                                $pct_cukup = $total_responses > 0 ? ($row->cukup / $total_responses * 100) : 0;
                                                $pct_baik = $total_responses > 0 ? ($row->baik / $total_responses * 100) : 0;
                                                $pct_sangat_baik = $total_responses > 0 ? ($row->sangat_baik / $total_responses * 100) : 0;

<<<<<<< HEAD
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
=======
                                                $total_sangat_kurang += $row->sangat_kurang;
                                                $total_kurang += $row->kurang;
                                                $total_cukup += $row->cukup;
                                                $total_baik += $row->baik;
                                                $total_sangat_baik += $row->sangat_baik;
                                            @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td class="text-left">{{ $row->pertanyaan }}</td>
                                                <td>{!! $pct_sangat_kurang == 0 ? '<span class="zero-value">0.00%</span>' : number_format($pct_sangat_kurang, 2) . '%' !!}
                                                </td>
                                                <td>{!! $pct_kurang == 0 ? '<span class="zero-value">0.00%</span>' : number_format($pct_kurang, 2) . '%' !!}
                                                </td>
                                                <td>{!! $pct_cukup == 0 ? '<span class="zero-value">0.00%</span>' : number_format($pct_cukup, 2) . '%' !!}
                                                </td>
                                                <td>{!! $pct_baik == 0 ? '<span class="zero-value">0.00%</span>' : number_format($pct_baik, 2) . '%' !!}
                                                </td>
                                                <td>{!! $pct_sangat_baik == 0 ? '<span class="zero-value">0.00%</span>' : number_format($pct_sangat_baik, 2) . '%' !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        @php
                                            $total_all = $total_sangat_kurang + $total_kurang + $total_cukup + $total_baik + $total_sangat_baik;
                                            $total_pct_sangat_kurang = $total_all > 0 ? ($total_sangat_kurang / $total_all * 100) : 0;
                                            $total_pct_kurang = $total_all > 0 ? ($total_kurang / $total_all * 100) : 0;
                                            $total_pct_cukup = $total_all > 0 ? ($total_cukup / $total_all * 100) : 0;
                                            $total_pct_baik = $total_all > 0 ? ($total_baik / $total_all * 100) : 0;
                                            $total_pct_sangat_baik = $total_all > 0 ? ($total_sangat_baik / $total_all * 100) : 0;
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{!! $total_pct_sangat_kurang == 0 ? '<span class="zero-value">0.00%</span>' : number_format($total_pct_sangat_kurang, 2) . '%' !!}
                                            </td>
                                            <td>{!! $total_pct_kurang == 0 ? '<span class="zero-value">0.00%</span>' : number_format($total_pct_kurang, 2) . '%' !!}
                                            </td>
                                            <td>{!! $total_pct_cukup == 0 ? '<span class="zero-value">0.00%</span>' : number_format($total_pct_cukup, 2) . '%' !!}
                                            </td>
                                            <td>{!! $total_pct_baik == 0 ? '<span class="zero-value">0.00%</span>' : number_format($total_pct_baik, 2) . '%' !!}
                                            </td>
                                            <td>{!! $total_pct_sangat_baik == 0 ? '<span class="zero-value">0.00%</span>' : number_format($total_pct_sangat_baik, 2) . '%' !!}
                                            </td>
                                        </tr>
                                    </tfoot>
>>>>>>> 9ad27f5b2a656d319a7d5b79aafba9c9ce0baca2
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Swiper Charts for Individual Questions -->
            @if(count($chartData) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-primary">Detail Penilaian per Aspek</h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper" id="swiperWrapper">
                                        @foreach($chartData as $key => $data)
                                            <div class="swiper-slide" data-question-id="{{ $key }}">
                                                <div class="card h-100 border-0 shadow-sm w-100">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">{{ $data['pertanyaan'] }}</h6>
                                                    </div>
                                                    <div class="card-body p-5">
                                                        <canvas id="chart{{ $key }}" style="width: 100%; width: 500px;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Empty State Message -->
                                    <div class="swiper-empty-message" id="emptyMessage">
                                        Tidak ada data untuk filter ini.
                                    </div>
                                    <!-- Swiper Controls -->
                                    <div class="swiper-pagination mt-3"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
<<<<<<< HEAD
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
=======
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
>>>>>>> 9ad27f5b2a656d319a7d5b79aafba9c9ce0baca2
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

    <script>
<<<<<<< HEAD
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
=======
        // Tambahkan setelah inisialisasi semua chart dan tabel
        let selectedProgram = 'all';
        let selectedYearRange = 'all';

        function applyGlobalFilters() {
            const currentYear = new Date().getFullYear();
            const yearFilterMin = selectedYearRange === 'all' ? null : currentYear - 3;

            // Tambahkan filter global DataTables
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                const tableId = settings.nTable.id;
                const tahun = parseInt(data[1]);
                const progStudi = data[0]; // Asumsikan kolom pertama adalah Program Studi

                if (yearFilterMin && tahun < yearFilterMin) return false;
                if (selectedProgram !== 'all' && !progStudi.includes(selectedProgram)) return false;

                return true;
            });

            // Redraw semua tabel
            ['#sebaran', '#masaTunggu', '#data'].forEach(id => {
                const table = $(id).DataTable();
                table.draw();
            });

            $.fn.dataTable.ext.search.pop();

            // Filter untuk Chart
            const filteredYears = allYears.filter(year => {
                return !yearFilterMin || parseInt(year) >= yearFilterMin;
            });

            const filteredLulusan = filteredYears.map(year => {
                const data = jumlahLulusan.find(item => {
                    return item.tahun_lulus == year && (selectedProgram === 'all' || item.program_studi === selectedProgram);
                });
                return data ? data.jumlah : 0;
            });

            statsChart.data.labels = filteredYears;
            statsChart.data.datasets[0].data = filteredLulusan;
            statsChart.update();
        }

        // Listener untuk dropdown filter
        $('#programStudiFilter').on('change', function () {
            selectedProgram = $(this).val();
            applyGlobalFilters();
        });

        $('#tahunRangeFilter').on('change', function () {
            selectedYearRange = $(this).val();
            applyGlobalFilters();
        });

        $(document).ready(function () {
            // Common DataTables Configuration
            const commonConfig = {
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data tersedia",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    searchPlaceholder: "Ketik untuk mencari..."
                },
                drawCallback: function () {
                    $('[data-toggle="tooltip"]').tooltip(); // Reinitialize tooltips
                }
            };

            // Sebaran Table
            $('#sebaran').DataTable({
                ...commonConfig,
                order: [[1, 'desc']], // Sort by Tahun Lulus descending
                columnDefs: [
                    { responsivePriority: 1, targets: [0, 1] }, // Prioritize No, Tahun
                    { responsivePriority: 2, targets: [2, 3] }  // Jml. Lulusan, Terlacak
                ]
            });

            // Masa Tunggu Table
            $('#masaTunggu').DataTable({
                ...commonConfig,
                order: [[1, 'desc']], // Sort by Tahun descending
                columnDefs: [
                    { responsivePriority: 1, targets: [0, 1] }, // Prioritize No, Tahun
                    { responsivePriority: 2, targets: [2, 3] }  // Jml. Lulusan, Terlacak
                ]
            });

            // Survei Table
            $('#data').DataTable({
                ...commonConfig,
                order: [[0, 'asc']], // Sort by No ascending
                columnDefs: [
                    { responsivePriority: 1, targets: [0, 1] }, // Prioritize No, Pertanyaan
                    { responsivePriority: 2, targets: [5, 6] }  // Baik, Sangat Baik
                ]
            });

            // Sebaran Table Filter
            $(document).on('click', '.sebaran-filter', function (e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const selectedText = $(this).text();
                $('#sebaranFilter').text(selectedText);

                console.log('Applying Sebaran filter:', filter); // Debug

                const table = $('#sebaran').DataTable();
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        if (settings.nTable.id !== 'sebaran') return true;

                        const tahun = parseInt(data[1]); // Tahun Lulus
                        const kerjaInfokom = parseInt(data[4]) || 0; // Kerja Infokom
                        const kerjaNonInfokom = parseInt(data[5]) || 0; // Kerja Non Infokom
                        const international = parseInt(data[6]) || 0; // International
                        const nasional = parseInt(data[7]) || 0; // Nasional
                        const wirausaha = parseInt(data[8]) || 0; // Wirausaha

                        switch (filter) {
                            case 'all':
                                return true;
                            case 'infokom':
                                return kerjaInfokom > 0;
                            case 'non_infokom':
                                return kerjaNonInfokom > 0;
                            case 'international':
                                return international > 0 || nasional > 0 || wirausaha > 0;
                            case 'recent':
                                return tahun >= 2025;
                        }
                        return true;
                    }
                );

                table.draw();
                $.fn.dataTable.ext.search.pop();

                console.log('Sebaran rows visible:', table.rows({ filter: 'applied' }).count()); // Debug
            });

            // Masa Tunggu Table Filter
            $(document).on('click', '.tunggu-filter', function (e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const selectedText = $(this).text();
                $('#tungguFilter').text(selectedText);

                console.log('Applying Masa Tunggu filter:', filter); // Debug

                const table = $('#masaTunggu').DataTable();
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        if (settings.nTable.id !== 'masaTunggu') return true;

                        const tahun = parseInt(data[1]); // Tahun
                        const rataTunggu = parseFloat(data[4]) || 0; // Rata-Rata Tunggu

                        switch (filter) {
                            case 'all':
                                return true;
                            case 'recent':
                                return tahun >= 2025;
                            case 'has_tunggu':
                                return rataTunggu > 0;
                        }
                        return true;
                    }
                );

                table.draw();
                $.fn.dataTable.ext.search.pop();

                console.log('Masa Tunggu rows visible:', table.rows({ filter: 'applied' }).count()); // Debug
            });

            // Survei Table Filter
            $(document).on('click', '.survei-filter', function (e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const selectedText = $(this).text();
                $('#surveiFilter').text(selectedText);

                console.log('Applying Survei filter:', filter); // Debug

                const table = $('#data').DataTable();
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        if (settings.nTable.id !== 'data') return true;

                        // Parse percentage strings (e.g., "50.00%" or "0.00%")
                        const parsePercentage = (str) => parseFloat(str.replace('%', '')) || 0;
                        const sangatKurang = parsePercentage(data[2]);
                        const kurang = parsePercentage(data[3]);
                        const cukup = parsePercentage(data[4]);
                        const baik = parsePercentage(data[5]);
                        const sangatBaik = parsePercentage(data[6]);

                        switch (filter) {
                            case 'all':
                                return true;
                            case 'has_responses':
                                return sangatKurang + kurang + cukup + baik + sangatBaik > 0;
                            case 'high_satisfaction':
                                return baik + sangatBaik > 40;
                            case 'low_satisfaction':
                                return sangatKurang + kurang > 40;
                        }
                        return true;
                    }
                );

                table.draw();
                $.fn.dataTable.ext.search.pop();

                console.log('Survei rows visible:', table.rows({ filter: 'applied' }).count()); // Debug
            });

            // Initialize Tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
        const colors = [
            '#A3CEF1', // Soft Blue
            '#FFD6A5', // Soft Orange
            '#FF9AA2', // Soft Red
            '#B5EAD7', // Soft Green
            '#E2F0CB', // Soft Lime
            '#CBAACB', // Soft Purple
            '#FFDAC1', // Soft Peach
            '#D0E6A5'  // Soft Olive
        ];

        // Chart 1: Data Pekerjaan Alumni (Pie Chart)
        const ctx1 = document.getElementById('myChart1').getContext('2d');
        const dataAlumniJob = @json($dataAlumniJob);

        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: dataAlumniJob.map(item => item.name),
                datasets: [{
                    data: dataAlumniJob.map(item => item.total),
                    backgroundColor: colors.slice(0, dataAlumniJob.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Chart 2: Data Jenis Instansi (Doughnut Chart)
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const dataInstansi = @json($dataInstansi);

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: dataInstansi.map(item => item.instansi_nama),
                datasets: [{
                    data: dataInstansi.map(item => item.total),
                    backgroundColor: colors.slice(0, dataInstansi.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Chart 3: Data Profesi Alumni (Pie Chart)
        const ctx3 = document.getElementById('myChart3').getContext('2d');
        const dataProfesi = @json($dataProfesi);

        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: dataProfesi.map(item => item.profesi),
                datasets: [{
                    data: dataProfesi.map(item => item.total),
                    backgroundColor: colors.slice(0, dataProfesi.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Stats Chart: Alumni by Graduation Year
        const ctxStats = document.getElementById('statsChart').getContext('2d');
        const jumlahLulusan = @json($jumlahLulusan);
        const result = @json($result);

        // Combine data for all years
        const allYears = [...new Set([...jumlahLulusan.map(item => item.tahun_lulus), ...result.map(item => item.tahun_lulus)])].sort();

        let statsChart = new Chart(ctxStats, {
            type: 'bar',
            data: {
                labels: allYears,
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: allYears.map(year => {
                        const lulusan = jumlahLulusan.find(item => item.tahun_lulus == year);
                        return lulusan ? lulusan.jumlah : 0;
                    }),
                    backgroundColor: colors[0],
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' alumni';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Alumni' }
                    },
                    x: {
                        title: { display: true, text: 'Tahun Lulus' }
                    }
                }
            }
        });

        // Dropdown filter for stats chart
        $(document).ready(function () {
            // Carousel dropdown filter
            $('.dropdown-item').on('click', function (e) {
                e.preventDefault();
                const slideIndex = $(this).data('slide-to');
                if (slideIndex !== undefined) {
                    $('#chartCarousel').carousel(slideIndex);
                    const selectedText = $(this).text();
                    $('#chartFilter').text(selectedText);
                }

                const filter = $(this).data('filter');
                if (filter) {
                    let datasetLabel = '';
                    let datasetData = [];

                    switch (filter) {
                        case 'all':
                            datasetLabel = 'Jumlah Alumni';
                            datasetData = allYears.map(year => {
                                const lulusan = jumlahLulusan.find(item => item.tahun_lulus == year);
                                return lulusan ? lulusan.jumlah : 0;
                            });
                            break;
                        case 'tracked':
                            datasetLabel = 'Alumni Terlacak';
                            datasetData = allYears.map(year => {
                                const res = result.find(item => item.tahun_lulus == year);
                                return res ? res.jumlah_terlacak : 0;
                            });
                            break;
                        case 'untracked':
                            datasetLabel = 'Alumni Tidak Terlacak';
                            datasetData = allYears.map(year => {
                                const lulusan = jumlahLulusan.find(item => item.tahun_lulus == year);
                                const res = result.find(item => item.tahun_lulus == year);
                                const total = lulusan ? lulusan.jumlah : 0;
                                const tracked = res ? res.jumlah_terlacak : 0;
                                return total - tracked;
                            });
                            break;
                        case 'infokom':
                            datasetLabel = 'Bidang Infokom';
                            datasetData = allYears.map(year => {
                                const res = result.find(item => item.tahun_lulus == year);
                                return res ? res.kerja_infokom : 0;
                            });
                            break;
                        case 'non_infokom':
                            datasetLabel = 'Bidang Non Infokom';
                            datasetData = allYears.map(year => {
                                const res = result.find(item => item.tahun_lulus == year);
                                return res ? res.kerja_non_infokom : 0;
                            });
                            break;
                        case 'belum_bekerja':
                            datasetLabel = 'Belum Bekerja';
                            datasetData = allYears.map(year => {
                                const res = result.find(item => item.tahun_lulus == year);
                                return res ? res.belum_bekerja : 0;
                            });
                            break;
                    }

                    statsChart.data.labels = allYears;
                    statsChart.data.datasets[0].label = datasetLabel;
                    statsChart.data.datasets[0].data = datasetData;
                    statsChart.data.datasets[0].backgroundColor = colors[0];
                    statsChart.update();

                    const selectedText = $(this).text();
                    $('#statsFilter').text(selectedText);
                }
            });
        });
        // Individual Charts for Survey Data
        const chartData = @json($chartData);
        const scaleLabels = ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
        const scaleColors = [
            '#F8BBD0', // Soft Pink
            '#FFE0B2', // Soft Orange
            '#FFF9C4', // Soft Yellow
            '#C8E6C9', // Soft Green
            '#BBDEFB'  // Soft Blue
        ];

        // Store Chart instances
        const chartInstances = {};

        Object.keys(chartData).forEach(function (key) {
            const ctx = document.getElementById('chart' + key);
            if (ctx) {
                chartInstances[key] = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: scaleLabels,
                        datasets: [{
                            label: 'Jumlah Responden',
                            data: chartData[key].data,
                            backgroundColor: scaleColors,
                            borderColor: scaleColors.map(color => color + '80'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return context.dataset.label + ': ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 },
                                title: { display: true, text: 'Jumlah Responden' }
                            },
                            x: {
                                title: { display: true, text: 'Skala Penilaian' }
                            }
                        }
                    }
                });
>>>>>>> 9ad27f5b2a656d319a7d5b79aafba9c9ce0baca2
            }
        });

        // Initialize Swiper
        let swiper = null;
        function initializeSwiper() {
            if (swiper) {
                swiper.destroy(true, true);
            }
            swiper = new Swiper('.mySwiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: Object.keys(chartData).length > 1, // Loop only if multiple slides
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
            });
        }

        @if(count($chartData) > 0)
            initializeSwiper();
        @endif

        // Filter Logic
        $(document).ready(function () {
            $('.dropdown-item').on('click', function (e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const selectedText = $(this).text();
                $('#surveyFilter').text(selectedText);

                // Filter slides based on chartData
                const slides = $('#swiperWrapper .swiper-slide');
                slides.hide();

                Object.keys(chartData).forEach(function (key) {
                    const slide = $(`[data-question-id="${key}"]`);
                    const data = chartData[key].data;
                    const totalResponses = data.reduce((a, b) => a + b, 0);
                    const highSatisfaction = data[3] + data[4]; // Baik + Sangat Baik
                    const lowSatisfaction = data[0] + data[1]; // Sangat Kurang + Kurang

                    switch (filter) {
                        case 'all':
                            slide.show();
                            break;
                        case 'has_responses':
                            if (totalResponses > 0) slide.show();
                            break;
                        case 'high_satisfaction':
                            if (highSatisfaction > 0) slide.show();
                            break;
                        case 'low_satisfaction':
                            if (lowSatisfaction > 0) slide.show();
                            break;
                    }
                });

                // Reinitialize Swiper to reflect visible slides
                initializeSwiper();
            });
        });
    </script>
@endpush