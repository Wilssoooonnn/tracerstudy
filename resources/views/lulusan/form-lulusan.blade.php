@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="py-5">
    <div class="container"> {{-- Gunakan container agar ada padding samping --}}
        <div class="row justify-content-center"> {{-- Tengah --}}
            <div class="col-12"> {{-- Lebar maksimal --}}
                <div class="card shadow">
                    <form>
                        <div class="card-header">
                            <h4 class="mb-0">Form Tracer Study</h4>
                        </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Program Studi</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun Lulus</label>
                                        <input type="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>No. Hp</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Pertama Kerja</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Mulai Kerja pada Instansi saat ini</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Instansi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Instansi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Skala</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Lokasi Instansi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Profesi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Profesi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Atasan Langsung</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan Atasan Langsung</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>No. Hp Atasan Langsung</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Atasan Langsung</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Message</label>
                                        <textarea class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
