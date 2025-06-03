@extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Rekap Tracer Study Lulusan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Tracer Study</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Rekap Tracer Study Lulusan</h4>
                        </div>

                        @empty($tracerRecord)
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                                Data Rekap Hasil Tracer Study tidak ditemukan.
                            </div>
                        @else
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $tracerRecord->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Alumni</th>
                                        <td>{{ $tracerRecord->data_alumni->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIM</th>
                                        <td>{{ $tracerRecord->data_alumni->nim ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Hp</th>
                                        <td>{{ $tracerRecord->data_alumni->nohp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $tracerRecord->data_alumni->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Kerja Pertama</th>
                                        <td>{{ $tracerRecord->first_job_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Masuk Instansi Saat Ini</th>
                                        <td>{{ $tracerRecord->current_instansi_start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Tunggu</th>
                                        <td>{{ $masaTunggu !== null ? $masaTunggu . ' bulan' : '-' }}</td>
                                    </tr>                                    
                                    <tr>
                                        <th>Jenis Instansi</th>
                                        <td>{{ $tracerRecord->instansi->instansi_nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Instansi</th>
                                        <td>{{ $tracerRecord->instansi_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Skala Instansi</th>
                                        <td>{{ $tracerRecord->skala->skala_nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi Instansi</th>
                                        <td>{{ $tracerRecord->instansi_location }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori Profesi</th>
                                        <td>{{ $tracerRecord->category->category }}</td>
                                    </tr>
                                    <tr>
                                        <th>Profesi</th>
                                        <td>{{ $tracerRecord->profesi->profesi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Atasan</th>
                                        <td>{{ $tracerRecord->nama_atasan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $tracerRecord->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. HP Atasan</th>
                                        <td>{{ $tracerRecord->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $tracerRecord->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>{{ $tracerRecord->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diperbarui Pada</th>
                                        <td>{{ $tracerRecord->updated_at }}</td>
                                    </tr>
                                </table>
                                <a href="{{ url('admin/rekap-hasil-lulusan') }}" class="btn btn-sm btn-danger mt-2">Kembali</a>
                            </div>
                        @endempty

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
