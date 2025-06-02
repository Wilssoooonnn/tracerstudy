@extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Stakeholder</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table Stakeholder</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Stakeholder</h4>
                        </div>

                        @empty($stakeholder)
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                                Data yang Anda cari tidak ditemukan.
                            </div>
                        @else
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $stakeholder->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $stakeholder->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Instansi</th>
                                        <td>{{ $stakeholder->instansi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $stakeholder->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $stakeholder->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Alumni</th>
                                        <td>{{ $stakeholder->alumni_id}}</td>
                                    </tr>
                                </table>
                                <a href="{{ url('admin/data-stakeholder') }}" class="btn btn-sm btn-success mt-2">Kembali</a>
                            </div>
                        @endempty

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
