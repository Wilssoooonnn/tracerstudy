@extends('layouts.form')

@section('title', 'Form Instansi')

@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>

        .card-header {
            background-color: #ffffff;
            color: #000000;
        }

        .survey-section-header {
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #000000;
        }

        .survey-question {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .survey-radios .form-check-label {
            margin-right: 1rem;
        }
        .survey-radios {
            margin-top: 0.5rem;
        }
    </style>
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
                            <h4 class="mb-0">Form Survey Kepuasan</h4>
                        </div>

                        <div class="card-body">
                            {{-- Data Lulusan --}}
                            <div class="form-group">
                                <label>Nama</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="nama"
                                    value="{{ old('nama', $nama) }}"
                                    readonly
                                >
                            </div>

                            <div class="form-group">
                                <label>Program Studi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="program_nama"
                                    value="{{ old('program_nama', $program_nama) }}"
                                    readonly
                                >
                            </div>

                            <div class="form-group">
                                <label>Tanggal Lulus</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="tanggal_lulus"
                                    value="{{ old('tanggal_lulus', $tanggal_lulus) }}"
                                    readonly
                                >
                            </div>

                            {{-- Kontak --}}
                            <div class="form-group">
                                <label>No. Hp</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="no_hp"
                                    value="{{ old('no_hp', $no_hp) }}"
                                    readonly
                                >
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email', $email) }}"
                                    readonly
                                >
                            </div>

                            <div class="survey-section-header">
                                Penilaian Kompetensi Alumni oleh Pengguna (Skala 1–5)
                            </div>

                            {{-- 1. Kemampuan bekerjasama dalam tim --}}
                            <div class="form-group">
                                <div class="survey-question">
                                    1. Kemampuan bekerjasama dalam tim
                                </div>
                                <div class="survey-radios">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="kerjasama"
                                                id="kerjasama{{ $i }}"
                                                value="{{ $i }}"
                                                {{ old('kerjasama') == $i ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label" for="kerjasama{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- 2. Etos kerja (disiplin, tanggung jawab, dll) --}}
                            <div class="form-group">
                                <div class="survey-question">
                                    2. Etos kerja (disiplin, tanggung jawab, dll)
                                </div>
                                <div class="survey-radios">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="etos_kerja"
                                                id="etosKerja{{ $i }}"
                                                value="{{ $i }}"
                                                {{ old('etos_kerja') == $i ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label" for="etosKerja{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- 3. Kemampuan berkomunikasi --}}
                            <div class="form-group">
                                <div class="survey-question">
                                    3. Kemampuan berkomunikasi
                                </div>
                                <div class="survey-radios">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="kemampuan_bahasa"
                                                id="bahasa{{ $i }}"
                                                value="{{ $i }}"
                                                {{ old('kemampuan_bahasa') == $i ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label" for="bahasa{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- 4. Penguasaan bidang IT --}}
                            <div class="form-group">
                                <div class="survey-question">
                                    4. Penguasaan bidang IT
                                </div>
                                <div class="survey-radios">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="kemampuan_it"
                                                id="it{{ $i }}"
                                                value="{{ $i }}"
                                                {{ old('kemampuan_it') == $i ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label" for="it{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="card-footer text-right">
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#confirmModal"
                            >
                                Submit
                            </button>
                        </div>

                        {{-- Modal Konfirmasi --}}
                        <div
                            class="modal fade"
                            id="confirmModal"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="confirmModalLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi</h5>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Tutup"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Setelah disimpan, jawaban tidak dapat diubah. Yakin ingin menyimpan?
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-dismiss="modal"
                                        >
                                            Batal
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            id="btnConfirmSubmit"
                                        >
                                            Ya, Simpan
                                        </button>
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

            $('#btnConfirmSubmit').click(function () {
                $('#formInstansi').submit();
            });
        });
    </script>
@endpush
