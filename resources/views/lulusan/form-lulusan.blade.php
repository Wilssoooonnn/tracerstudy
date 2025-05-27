@extends('layouts.form')

@section('title', 'Form Lulusan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow">
                        <form>
                            <div class="card-header">
                                <h4 class="mb-0">Form Tracer Study</h4>
                            </div>
                            <div class="card-body">
                                {{-- <form method="POST" action="{{ route('simpan-tracer-study') }}"> --}}
                                    @csrf
                                
                                    <div class="form-group">
                                        <label>Program Studi</label>
                                        <input type="text" class="form-control" name="programs_id" required
                                            value="{{ old('programs_id',$programs_id) }}" readonly>
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
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pertama Kerja</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai Kerja pada Instansi saat ini</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Instansi</label>
                                    <select class="form-control" name="jenis_instansi" required>
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        <option value="pendidikan-tinggi">Pendidikan Tinggi</option>
                                        <option value="instansi-pemerintah">Instansi Pemerintah</option>
                                        <option value="perusahaan-swasta">Perusahaan Swasta</option>
										<option value="bumn">BUMN</option>
                                    </select>
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
                                    <select class="form-control" name="kategori_profesi" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="infokom">Infokom</option>
                                        <option value="non-infokom">Non-Infokom</option>
                                    </select>
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
                            </div>
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#confirmModal">
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
                                        <button type="button" class="btn btn-primary" id="btnConfirmSubmit">Ya,
                                            Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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