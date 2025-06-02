@extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Update Pertanyaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table Pertanyaan</div>
            </div>
        </div>

        <div class="section-body">
            @empty($pertanyaan)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('pertanyaan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Update Pertanyaan</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ url('/pertanyaan/' . $pertanyaan->id) }}" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="pertanyaan">Pertanyaan</label>
                                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan"
                                            value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}" required>
                                        @error('pertanyaan')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group text-right">
                                        <a href="{{ url('pertanyaan') }}" class="btn btn-warning">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty
        </div>
    </section>
</div>
@endsection
