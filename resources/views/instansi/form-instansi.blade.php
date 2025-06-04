@extends('layouts.form')

@section('title', 'Form Instansi Multi-step')

@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.css">
@endpush

@section('main')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <form id="formInstansi" action="{{ route('instansi.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="card-header">
                                <h4 class="mb-0">Form Survey Kepuasan</h4>
                            </div>

                            <div class="card-body">
                                {{-- Step 1 --}}
                                <div id="step1" class="step-section">
                                    <h5 class="mb-4 border-bottom pb-2">Data Lulusan & Instansi</h5>

                                    <div class="mb-3">
                                        <label class="form-label">Nama Atasan</label>
                                        <input type="text" class="form-control" name="nama"
                                            value="{{ old('atasan_nama', $nama_atasan ?? '') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nama Instansi</label>
                                        <input type="text" class="form-control" name="nama_instansi"
                                            value="{{ old('instansi_name', $nama_instansi ?? '') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan"
                                            value="{{ old('jabatan', $jabatan ?? '') }}" readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Email Atasan</label>
                                        <input type="email" class="form-control" name="email_atasan"
                                            value="{{ old('email_atasan', $email ?? '') }}" readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Lulusan</label>
                                        <input type="text" class="form-control" name="alumni"
                                            value="{{ old('alumni', $nama . ' - ' . $nim . ' - ' . $program_nama ?? '') }}"
                                            readonly>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="btnNext" class="btn btn-primary">Next</button>
                                    </div>
                                </div>

                                {{-- Step 2 --}}
                                <div id="step2" class="step-section d-none">
                                    <h5 class="mb-4 border-bottom pb-2">Penilaian Kompetensi Alumni oleh Pengguna (Skala
                                        1-5)</h5>

                                    @foreach ($pertanyaan as $question)
                                        <div class="form-group">
                                            <label class="form-label d-block">{{ $question->pertanyaan }}</label>
                                            @if ($question->question_type == 'scale')
                                                <div class="selectgroup w-100">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <label class="selectgroup-item" for="{{ $question->id }}{{ $i }}">
                                                            <input class="selectgroup-input" type="radio"
                                                                name="question[{{ $question->id }}]" id="{{ $question->id }}{{ $i }}"
                                                                value="{{ $i }}" required>
                                                            <span class="selectgroup-button">{{ $i }}</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            @elseif ($question->question_type == 'text')
                                                <input type="text" class="form-control" name="question[{{ $question->id }}]"
                                                    value="{{ old('question.' . $question->id) }}" required>
                                            @endif
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="btnBack" class="btn btn-secondary">Back</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#confirmModal">Submit</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">×</span>
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
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show Step 2 on Next button click
            $('#btnNext').click(function () {
                $('#step1').addClass('d-none');
                $('#step2').removeClass('d-none');
            });

            // Show Step 1 on Back button click
            $('#btnBack').click(function () {
                $('#step2').addClass('d-none');
                $('#step1').removeClass('d-none');
            });

            // Handle form submission via AJAX
            $('#btnConfirmSubmit').click(function () {
                // Client-side validation
                if ($('#formInstansi')[0].checkValidity()) {
                    $('#confirmModal').modal('hide');
                    let formData = $('#formInstansi').serialize();

                    $.ajax({
                        url: "{{ route('instansi.store') }}",
                        type: "POST",
                        data: formData,
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "{{ route('instansi.index') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = 'An error occurred while submitting the form.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage += ' ' + Object.values(xhr.responseJSON.errors).join(' ');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Form',
                        text: 'Please fill out all required fields.',
                        confirmButtonText: 'OK'
                    });
                    $('#formInstansi')[0].reportValidity();
                }
            });
        });
    </script>
@endpush