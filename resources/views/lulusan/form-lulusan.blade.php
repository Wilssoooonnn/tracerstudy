@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<<<<<<< HEAD
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow">
                        <form action="{{ route('lulusan.store') }}" method="POST">
                            <div class="card-header">
                                <h4 class="mb-0">Form Tracer Study</h4>
                            </div>
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="nim" value="{{ $nim }}">
                                <div class="form-group">
                                    <label>Program Studi</label>
                                    <input type="text" class="form-control" name="program_nama" required
                                        value="{{ old('program_nama', $program_nama) }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lulus</label>
                                    <input type="text" class="form-control" name="tanggal_lulus"
                                        value="{{ old('tanggal_lulus', $tanggal_lulus) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ old('nama', $nama) }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No. Hp</label>
                                    <input type="text" class="form-control" name="no_hp">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pertama Kerja</label>
                                    <input type="date" class="form-control" name="tanggal_pertama_kerja">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai Kerja pada Instansi saat ini</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_kerja">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Instansi</label>
                                    <select class="form-control" name="instansi_id" required>
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        @foreach ($semuaInstansi as $instansi)
                                            <option value="{{ $instansi->id }}"
                                                {{ $alumni->instansi_id == $instansi->id ? 'selected' : '' }}>
                                                {{ $instansi->instansi_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi">
                                </div>
                                <div class="form-group">
                                    <label>Skala</label>
                                    <select name="skala_id" class="form-control" required>
                                        <option value="">-- Pilih Skala --</option>
                                        @foreach ($semuaSkala as $skala)
                                            <option value="{{ $skala->id }}"
                                                {{ $skala_id == $skala->id ? 'selected' : '' }}>
                                                {{ $skala->skala_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Instansi</label>
                                    <input type="text" class="form-control" name="lokasi_instansi">
                                </div>
                                <div class="form-group">
                                    <label>Kategori Profesi</label>
                                    <select class="form-control" name="kategori_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($semuaKategori as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ $alumni->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Profesi</label>
                                    <input type="hidden" name="profesi_id" id="profesi_id">
                                    <input type="text" class="form-control"  name="profesi_input" id="profesi_input" required autocomplete="off">
                                </div>                                                        
                                <div class="form-group">
                                    <label>Nama Atasan Langsung</label>
                                    <input type="text" class="form-control" name="nama_atasan">
                                </div>
                                <div class="form-group">
                                    <label>Jabatan Atasan Langsung</label>
                                    <input type="text" class="form-control" name="jabatan">
                                </div>
                                <div class="form-group">
                                    <label>No. Hp Atasan Langsung</label>
                                    <input type="text" class="form-control"name="noHp_atasan">
                                </div>
                                <div class="form-group">
                                    <label>Email Atasan Langsung</label>
                                    <input type="text" class="form-control" name="email_atasan">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#confirmModal">
                                    Submit
                                </button>
                            </div>
                        
                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Setelah disimpan, jawaban tidak dapat diubah. Yakin ingin menyimpan?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-primary" id="btnConfirmSubmit">Ya,Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
=======
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
<<<<<<< HEAD

@push('scripts')
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
        $('#btnConfirmSubmit').on('click', function () {
            $('form').submit(); // atau $('#formTracer').submit(); jika kamu pakai id
        });
        let profesiList = [
            @foreach ($daftarProfesi as $profesi)
                "{{ $profesi->profesi }}",
            @endforeach
        ];

        $("#profesi_input").autocomplete({
            source: profesiList
        });
    });
</script>

@endpush
=======
>>>>>>> 2f06ecd2c1a0a88757842d16c6c9895883e1c34d

@push('scripts')
    <!-- JS Libraries -->
@endpush