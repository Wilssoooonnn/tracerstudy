@extends('layouts.app')

@section('title', 'Rekap Belum Mengisi Pengguna Lulusan')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekap Belum Mengisi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Rekap Belum Mengisi Pengguna</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rekap Belum Mengisi Pengguna Lulusan</h4>
                            <div class="card-header-form ml-auto">
                                <a href="{{ route('rekapbelummengisipenggunalulusan.export_excel') }}" class="btn btn-primary">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableRekapPengguna">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Atasan</th>
                                            <th>Instansi</th>
                                            <th>Jabatan</th>
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
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        $('#tableRekapPengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('rekapbelummengisipenggunalulusan.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'instansi', name: 'instansi' },
                { data: 'jabatan', name: 'jabatan' }
            ]
        });
    });
</script>
@endpush