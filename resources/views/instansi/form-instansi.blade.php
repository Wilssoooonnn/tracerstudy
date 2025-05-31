@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('main')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow">
                    <form id="formInstansi" action="{{ route('instansi.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4 class="mb-0">Form Tracer Study</h4>
                        </div>
                        <div class="card-body">
                            {{-- Data Lulusan --}}
                            <div class="form-group">
                                <label>Program Studi</label>
                                <input type="text" class="form-control" name="program_nama" value="{{ old('program_nama', $program_nama) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lulus</label>
                                <input type="text" class="form-control" name="tanggal_lulus" value="{{ old('tanggal_lulus', $tanggal_lulus) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama', $nama) }}" readonly>
                            </div>

                            {{-- Kontak --}}
                            <div class="form-group">
                                <label>No. Hp</label>
                                <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp') }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                            </div>

                            {{-- Tanggal --}}
                            <div class="form-group">
                                <label>Tanggal Pertama Kerja</label>
                                <input type="date" class="form-control" name="tgl_kerja_pertama" value="{{ old('tgl_kerja_pertama') }}">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Mulai Kerja pada Instansi Saat Ini</label>
                                <input type="date" class="form-control" name="tgl_mulai_instansi" value="{{ old('tgl_mulai_instansi') }}">
                            </div>

                            {{-- Instansi --}}
                            <div class="form-group">
                                <label>Jenis Instansi</label>
                                <select class="form-control" name="jenis_instansi" required>
                                    <option value="">-- Pilih Jenis Instansi --</option>
                                    @foreach ($semuaInstansi as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('jenis_instansi', $alumni->instansi_id) == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->instansi_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Instansi</label>
                                <input type="text" class="form-control" name="nama_instansi" value="{{ old('nama_instansi') }}">
                            </div>
                            <div class="form-group">
                                <label>Skala</label>
                                <select name="skala_id" class="form-control" required>
                                    <option value="">-- Pilih Skala --</option>
                                    @foreach ($semuaSkala as $skala)
                                        <option value="{{ $skala->id }}" {{ old('skala_id', $skala_id) == $skala->id ? 'selected' : '' }}>
                                            {{ $skala->skala_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Instansi</label>
                                <input type="text" class="form-control" name="lokasi_instansi" value="{{ old('lokasi_instansi') }}">
                            </div>

                            {{-- Profesi --}}
                            <div class="form-group">
                                <label>Kategori Profesi</label>
                                <select class="form-control" name="kategori_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($semuaKategori as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $alumni->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Profesi</label>
                                <input type="text" class="form-control" name="profesi" id="profesi_input" value="{{ old('profesi') }}" required autocomplete="off">
                            </div>

                            {{-- Atasan --}}
                            <div class="form-group">
                                <label>Nama Atasan Langsung</label>
                                <input type="text" class="form-control" name="nama_atasan" value="{{ old('nama_atasan') }}">
                            </div>
                            <div class="form-group">
                                <label>Jabatan Atasan Langsung</label>
                                <input type="text" class="form-control" name="jabatan_atasan" value="{{ old('jabatan_atasan') }}">
                            </div>
                            <div class="form-group">
                                <label>No. Hp Atasan Langsung</label>
                                <input type="text" class="form-control" name="no_hp_atasan" value="{{ old('no_hp_atasan') }}">
                            </div>
                            <div class="form-group">
                                <label>Email Atasan Langsung</label>
                                <input type="text" class="form-control" name="email_atasan" value="{{ old('email_atasan') }}">
                            </div>

                            <hr>
                            <h5 class="mb-3">Penilaian Kompetensi Alumni oleh Pengguna (Skala 1–5)</h5>

                            {{-- Penilaian --}}
                            <div class="form-group">
                                <label>1. Kemampuan bekerjasama dalam tim</label>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="mr-2">
                                            <input type="radio" name="kerjasama" value="{{ $i }}" {{ old('kerjasama') == $i ? 'checked' : '' }} required> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label>2. Etos kerja (disiplin, tanggung jawab, dll)</label>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="mr-2">
                                            <input type="radio" name="etos_kerja" value="{{ $i }}" {{ old('etos_kerja') == $i ? 'checked' : '' }} required> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label>3. Kemampuan berkomunikasi</label>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="mr-2">
                                            <input type="radio" name="kemampuan_bahasa" value="{{ $i }}" {{ old('kemampuan_bahasa') == $i ? 'checked' : '' }} required> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label>4. Penguasaan bidang IT</label>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="mr-2">
                                            <input type="radio" name="kemampuan_it" value="{{ $i }}" {{ old('kemampuan_it') == $i ? 'checked' : '' }} required> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">
                                Submit
                            </button>
                        </div>

                        {{-- Modal Konfirmasi --}}
                        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
                                        <button type="submit" class="btn btn-primary" id="btnConfirmSubmit">Ya, Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        let profesiList = [
            @foreach ($daftarProfesi as $profesi)
                "{{ $profesi->profesi }}",
            @endforeach
        ];
        $("#profesi_input").autocomplete({ source: profesiList });

        // Modal submit
        $('#btnConfirmSubmit').click(function () {
            $('#formInstansi').submit();
        });
    });
</script>
@endpush
