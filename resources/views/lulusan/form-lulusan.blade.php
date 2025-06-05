@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('main')
    <div class="py-5">
        <div class="container"> {{-- Gunakan container agar ada padding samping --}}
            <div class="row justify-content-center"> {{-- Tengah --}}
                <div class="col-12"> {{-- Lebar maksimal --}}
                    <div class="card shadow">
                        <form action="{{ route('lulusan.store') }}" method="POST">
                            <div class="card-header">
                                <h4 class="mb-0">Form Tracer Study</h4>
                            </div>
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="nim" value="{{ $nim }}">
                                <!-- Program Studi -->
                                <div class="form-group">
                                    <label>Program Studi</label>
                                    <input type="text" class="form-control" name="program_nama" required
                                           value="{{ old('program_nama', $program_nama) }}" readonly>
                                </div>

                                <!-- Tanggal Lulus -->
                                <div class="form-group">
                                    <label>Tanggal Lulus</label>
                                    <input type="text" class="form-control" name="tanggal_lulus"
                                           value="{{ old('tanggal_lulus', $tanggal_lulus) }}" readonly>
                                </div>

                                <!-- Nama -->
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama"
                                           value="{{ old('nama', $nama) }}" readonly>
                                </div>

                                <!-- No. Hp -->
                                <div class="form-group">
                                    <label>No. Hp</label>
                                    <input type="text" class="form-control" name="no_hp">
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="nama"
                                           value="{{ old('email', $email) }}" readonly>
                                </div>

                                <!-- Tanggal Pertama Kerja -->
                                <div class="form-group">
                                    <label>Tanggal Pertama Kerja</label>
                                    <input type="date" class="form-control" name="tanggal_pertama_kerja">
                                </div>

                                <!-- Tanggal Mulai Kerja pada Instansi saat ini -->
                                <div class="form-group">
                                    <label>Tanggal Mulai Kerja pada Instansi saat ini</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_kerja">
                                </div>

                                <!-- Jenis Instansi -->
                                <div class="form-group">
                                    <label>Jenis Instansi</label>
                                    <select class="form-control" name="instansi_id" required>
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        @foreach ($semuaInstansi as $instansi)
                                            <option value="{{ $instansi->id }}"
                                                {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                                {{ $instansi->instansi_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Nama Instansi -->
                                <div class="form-group">
                                    <label>Nama Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi">
                                </div>

                                <!-- Skala -->
                                <div class="form-group">
                                    <label>Skala</label>
                                    <select name="skala_id" class="form-control" required>
                                        <option value="">-- Pilih Skala --</option>
                                        @foreach ($semuaSkala as $skala)
                                            <option value="{{ $skala->id }}"
                                                {{ old('skala_id') == $skala->id ? 'selected' : '' }}>
                                                {{ $skala->skala_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Lokasi Instansi -->
                                <div class="form-group">
                                    <label>Lokasi Instansi</label>
                                    <input type="text" class="form-control" name="lokasi_instansi">
                                </div>

                                <!-- Kategori Profesi -->
                                <div class="form-group">
                                    <label>Kategori Profesi</label>
                                    <select class="form-control" name="kategori_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($semuaKategori as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Profesi -->
                                <div class="form-group">
                                    <label>Profesi</label>
                                    <input type="hidden" name="profesi_id" id="profesi_id">
                                    <input type="text" class="form-control" name="profesi_input" id="profesi_input" required autocomplete="off">
                                </div>

                                <!-- Nama Atasan Langsung -->
                                <div class="form-group">
                                    <label>Nama Atasan Langsung</label>
                                    <input type="text" class="form-control" name="nama_atasan">
                                </div>

                                <!-- Jabatan Atasan Langsung -->
                                <div class="form-group">
                                    <label>Jabatan Atasan Langsung</label>
                                    <input type="text" class="form-control" name="jabatan">
                                </div>

                                <!-- No. Hp Atasan Langsung -->
                                <div class="form-group">
                                    <label>No. Hp Atasan Langsung</label>
                                    <input type="text" class="form-control" name="noHp_atasan">
                                </div>

                                <!-- Email Atasan Langsung -->
                                <div class="form-group">
                                    <label>Email Atasan Langsung</label>
                                    <input type="email" class="form-control" name="email_atasan">
                                </div>
                            </div>

                            <!-- Confirmation Modal -->
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">
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
                                        <button type="button" class="btn btn-primary" id="btnConfirmSubmit">Ya, Simpan</button>
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

    <script>
        $(document).ready(function () {
            let profesiList = [
                @foreach ($daftarProfesi as $profesi)
                    "{{ $profesi->profesi }}",
                @endforeach
            ];

            $("#profesi_input").autocomplete({
                source: profesiList
            });

            $('#btnConfirmSubmit').on('click', function () {
                $('form').submit(); // Submit the form
            });
        });
    </script>
@endpush
