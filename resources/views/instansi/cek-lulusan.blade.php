@extends('layouts.form')

@section('title', 'Cek Lulusan')

@push('style')
    <!-- Tambahkan CSS Libraries di sini jika perlu -->
@endpush

@section('main')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3 class="mb-4">Verifikasi Data Lulusan</h3>
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('instansi.cek-lulusan.submit') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nim">Masukkan NIM:</label>
                                    <input type="text" name="nim" id="nim" class="form-control" required>
                                    @error('nim')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection