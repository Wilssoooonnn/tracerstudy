@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <style>
        .error { color: red; font-size: 0.9em; }
    </style>
@endpush

@section('main')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow">
                        @if (!$nim)
                            <div class="alert alert-danger">
                                Error: NIM is missing. Please ensure you accessed this form with a valid token.
                            </div>
                        @endif
                        <form action="{{ route('lulusan.store') }}" method="POST" id="tracerForm">
                            @csrf
                            @method('POST')
                            <div class="card-header">
                                <h4 class="mb-0">Form Tracer Study</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="nim" value="{{ $nim ?? '' }}">
                                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                                <!-- Program Studi (Display Only) -->
                                <div class="form-group">
                                    <label>Program Studi</label>
                                    <input type="text" class="form-control" value="{{ $program_nama ?? '-' }}" readonly>
                                    @error('nim') <span class="error">{{ $message }}</span> @enderror
                                    @error('token') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                {{-- Nim --}}
                                <div class="form-group">
                                    <label>NIM</label>
                                    <input type="text" class="form-control" value="{{ $nim ?? '-' }}" readonly>
                                </div>

                                <!-- Tanggal Lulus (Display Only) -->
                                <div class="form-group">
                                    <label>Tanggal Lulus</label>
                                    <input type="text" class="form-control" value="{{ $tanggal_lulus ?? '-' }}" readonly>
                                </div>

                                <!-- Nama (Display Only) -->
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $nama ?? '-' }}" readonly>
                                </div>

                                <!-- No. Hp -->
                                <div class="form-group">
                                    <label>No. Hp</label>
                                    <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp') }}">
                                    @error('no_hp') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $email ?? '') }}" readonly>
                                    @error('email') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Tanggal Pertama Kerja -->
                                <div class="form-group">
                                    <label>Tanggal Pertama Kerja</label>
                                    <input type="date" class="form-control" name="tanggal_pertama_kerja" value="{{ old('tanggal_pertama_kerja') }}">
                                    @error('tanggal_pertama_kerja') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Tanggal Mulai Kerja pada Instansi saat ini -->
                                <div class="form-group">
                                    <label>Tanggal Mulai Kerja pada Instansi saat ini</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_kerja" value="{{ old('tanggal_mulai_kerja') }}">
                                    @error('tanggal_mulai_kerja') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Jenis Instansi -->
                                <div class="form-group">
                                    <label>Jenis Instansi</label>
                                    <select class="form-control" name="instansi_id">
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        @foreach ($semuaInstansi as $instansi)
                                            <option value="{{ $instansi->id }}"
                                                {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                                {{ $instansi->instansi_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instansi_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Nama Instansi -->
                                <div class="form-group">
                                    <label>Nama Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi" value="{{ old('nama_instansi') }}">
                                    @error('nama_instansi') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Skala -->
                                <div class="form-group">
                                    <label>Skala</label>
                                    <select name="skala_id" class="form-control">
                                        <option value="">-- Pilih Skala --</option>
                                        @foreach ($semuaSkala as $skala)
                                            <option value="{{ $skala->id }}"
                                                {{ old('skala_id') == $skala->id ? 'selected' : '' }}>
                                                {{ $skala->skala_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('skala_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Lokasi Instansi -->
                                <div class="form-group">
                                    <label>Lokasi Instansi</label>
                                    <input type="text" class="form-control" name="lokasi_instansi" value="{{ old('lokasi_instansi') }}">
                                    @error('lokasi_instansi') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Kategori Profesi -->
                                <div class="form-group">
                                    <label>Kategori Profesi</label>
                                    <select class="form-control" name="kategori_id">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($semuaKategori as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Profesi -->
                                <div class="form-group">
                                    <label>Profesi</label>
                                    <input type="hidden" name="profesi_id" id="profesi_id" value="{{ old('profesi_id') }}">
                                    <input type="text" class="form-control" name="profesi_input" id="profesi_input" value="{{ old('profesi_input') }}" autocomplete="off">
                                    @error('profesi_input') <span class="error">{{ $message }}</span> @enderror
                                    @error('profesi_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Nama Atasan Langsung -->
                                <div class="form-group">
                                    <label>Nama Atasan Langsung</label>
                                    <input type="text" class="form-control" name="nama_atasan" value="{{ old('nama_atasan') }}">
                                    @error('nama_atasan') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Jabatan Atasan Langsung -->
                                <div class="form-group">
                                    <label>Jabatan Atasan Langsung</label>
                                    <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}">
                                    @error('jabatan') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- No. Hp Atasan Langsung -->
                                <div class="form-group">
                                    <label>No. Hp Atasan Langsung</label>
                                    <input type="text" class="form-control" name="noHp_atasan" value="{{ old('noHp_atasan') }}">
                                    @error('noHp_atasan') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Email Atasan Langsung -->
                                <div class="form-group">
                                    <label>Email Atasan Langsung</label>
                                    <input type="email" class="form-control" name="email_atasan" value="{{ old('email_atasan') }}">
                                    @error('email_atasan') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="openConfirmModal" data-toggle="modal" data-target="#confirmModal">
                                    Submit
                                </button>
                            </div>
                        </form>

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
                                        <button type="submit" class="btn btn-primary" form="tracerForm">Ya, Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Autocomplete for profesi
            let profesiList = [
                @foreach ($daftarProfesi as $profesi)
                    { id: {{ $profesi->id }}, label: "{{ $profesi->profesi }}" },
                @endforeach
            ];

            $("#profesi_input").autocomplete({
                source: profesiList,
                select: function (event, ui) {
                    $("#profesi_id").val(ui.item.id);
                    $("#profesi_input").val(ui.item.label);
                    return false;
                }
            });

            // Display validation errors
            @if ($errors->any())
                swal({
                    title: "Error!",
                    text: "{{ implode('\n', $errors->all()) }}",
                    icon: "error",
                    button: "OK",
                });
            @endif

            // Display success or error messages
            @if (session('success'))
                swal({
                    title: "Sukses!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    button: "OK",
                });
            @endif

            @if (session('error'))
                swal({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    button: "OK",
                });
            @endif
        });
    </script>
@endpush