@extends('layouts.form')

@section('title', 'Form Instansi Multi-step')

@push('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                                    <input type="text" class="form-control" name="nama" value="{{ old('atasan_nama', $nama_atasan ?? '') }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi" value="{{ old('instansi_name', $nama_instansi ?? '') }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="noHp_atasan" value="{{ old('noHp_atasan', $jabatan  ?? '') }}" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Email Atasan</label>
                                    <input type="email" class="form-control" name="email_atasan" value="{{ old('email_atasan', $email ?? '') }}" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Lulusan</label>
                                    <input type="email" class="form-control" name="alumni" value="{{ old('alumni', $nama . " - " . $nim . " - " . $program_nama ?? '') }}" readonly>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" id="btnNext" class="btn btn-primary">Next</button>
                                </div>
                            </div>

                            {{-- Step 2 --}}
                            <div id="step2" class="step-section d-none">
                                <h5 class="mb-4 border-bottom pb-2">Penilaian Kompetensi Alumni oleh Pengguna (Skala 1-5)</h5>

                                @php
                                    $pertanyaan = [
                                        'kerjasama' => '1. Kemampuan bekerjasama dalam tim',
                                        'etos_kerja' => '2. Etos kerja (disiplin, tanggung jawab, dll)',
                                        'kemampuan_bahasa' => '3. Kemampuan berkomunikasi',
                                        'kemampuan_it' => '4. Penguasaan bidang IT'
                                    ];
                                @endphp

                                @foreach ($pertanyaan as $name => $label)
                                    <div class="form-group">
                                        <label class="form-label d-block">{{ $label }}</label>
                                        <div class="selectgroup w-100">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="selectgroup-item" for="{{ $name }}{{ $i }}">
                                                    <input
                                                        class="selectgroup-input"
                                                        type="radio"
                                                        name="{{ $name }}"
                                                        id="{{ $name }}{{ $i }}"
                                                        value="{{ $i }}"
                                                        {{ old($name) == $i ? 'checked' : '' }}
                                                        required
                                                    >
                                                    <span class="selectgroup-button">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between">
                                    <button type="button" id="btnBack" class="btn btn-secondary">Back</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
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
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#btnNext').click(function () {
            $('#step1').addClass('d-none');
            $('#step2').removeClass('d-none');
        });

        $('#btnBack').click(function () {
            $('#step2').addClass('d-none');
            $('#step1').removeClass('d-none');
        });
    });
</script>
@endpush
