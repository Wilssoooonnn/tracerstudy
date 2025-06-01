@extends('layouts.form')

@section('title', 'Form Kepuasan Pengguna Lulusan')

@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('main')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow">
                    <form action="{{ route('instansi.store') }}" method="POST">
                        <div class="card-header">
                            <h4 class="mb-0">Form Survei Pengguna Lulusan</h4>
                        </div>
                        <div class="card-body">
                            @csrf

                            {{-- 1. Nama --}}
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama_pengisi" required>
                            </div>

                            {{-- 2. Instansi --}}
                            <div class="form-group">
                                <label>Instansi</label>
                                <input type="text" class="form-control" name="instansi" required>
                            </div>

                            {{-- 3. Jabatan --}}
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" required>
                            </div>

                            {{-- 4. Email --}}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            {{-- 5. Nama Alumni (search) --}}
                            <div class="form-group">
                                <label>Nama Alumni (Pilih berdasarkan Nama)</label>
                                <select name="alumni_id" class="form-control" required>
                                    <option value="">-- Pilih Alumni --</option>
                                    @foreach ($daftarAlumni as $alumni)
                                        <option value="{{ $alumni->id }}">
                                            {{ $alumni->program_studi }} – {{ $alumni->tahun_lulus }} – {{ $alumni->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 6–14: Pertanyaan Skala --}}
                            @php
                                $pertanyaan = [
                                    'Kerjasama Tim',
                                    'Keahlian di bidang TI',
                                    'Kemampuan berbahasa asing',
                                    'Kemampuan berkomunikasi',
                                    'Pengembangan diri',
                                    'Kepemimpinan',
                                    'Etos Kerja',
                                ];
                            @endphp

                            @foreach ($pertanyaan as $index => $teks)
                                <div class="form-group">
                                    <label>{{ ($index + 6) . '. ' . $teks }}</label>
                                    <select name="pertanyaan_{{ $index + 1 }}" class="form-control" required>
                                        <option value="">-- Pilih Penilaian --</option>
                                        <option value="1">Sangat Kurang</option>
                                        <option value="2">Kurang</option>
                                        <option value="3">Cukup</option>
                                        <option value="4">Baik</option>
                                        <option value="5">Sangat Baik</option>
                                    </select>
                                </div>
                            @endforeach

                            {{-- 13. Kompetensi yang belum terpenuhi --}}
                            <div class="form-group">
                                <label>Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
                                <textarea name="kompetensi_kurang" class="form-control" rows="3" required></textarea>
                            </div>

                            {{-- 14. Saran kurikulum --}}
                            <div class="form-group">
                                <label>Saran untuk kurikulum program studi</label>
                                <textarea name="saran_kurikulum" class="form-control" rows="3" required></textarea>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
