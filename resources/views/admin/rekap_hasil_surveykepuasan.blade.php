@extends('layouts.app')

@section('title', 'Rekap Hasil Survey Kepuasan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Hasil Survey Kepuasan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Rekap Hasil Survey Kepuasan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekap Hasil Tracer Study Lulusan</h4>
                                <div class="card-header-action">
                                    <a href="{{ url('/rekaphasilsurvey/export-rekap-survey') }}" class="btn btn-primary">
                                        <i class="fas fa-file-excel">
                                        </i> Export Data</a>
                                </div>
                            </div>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableRekapHasilSurvey" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Instansi</th>
                                                <th>Jabatan</th>
                                                <th>Email</th>
                                                <th>Nama Alumni</th>
                                                <th>Program Studi</th>
                                                <th>Tahun Lulus</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>                                    
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush

@push('js')
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $(document).ready(function () {
        var dataSurvey = $('#tableRekapHasilSurvey').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('rekaphasilsurvey/list') }}",
                dataType: "json",
                type: "POST"
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_stakeholder',
                    name: 'nama_stakeholder'
                },
                {
                    data: 'nama_instansi',
                    name: 'nama_instansi'
                },
                {
                    data: 'nama_jabatan',
                    name: 'nama_jabatan'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'nama_alumni',
                    name: 'nama_alumni'
                },
                {
                    data: 'program_studi',
                    name: 'program_studi'
                },
                {
                    data: 'tahun_lulus',
                    name: 'tahun_lulus'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>

@endpush
