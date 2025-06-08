@extends('layouts.app')

@section('title', 'Rekap Belum Mengisi Pengguna Lulusan')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekap Belum Mengisi Pengguna Lulusan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Rekap Belum Mengisi Pengguna Lulusan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rekap Belum Mengisi Pengguna Lulusan</h4>
                            <div class="card-header-form">
                                <form>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group w-auto">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('rekapbelummengisipenggunalulusan.export_excel') }}" class="btn btn-primary">
                                                <i class="fa fa-file-excel"></i> 
                                                Export Data
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="tableRekapPengguna">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Atasan</th>
                                            <th>Stakeholder</th>
                                            <th>Nama Lulusan</th>
                                            <th>Program Studi</th>
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
<!-- JS Libraries -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        $('#tableRekapPengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('rekapbelummengisipenggunalulusan.list') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Menambahkan CSRF token
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_atasan', name: 'nama_atasan' }, // Kolom Nama Atasan
                { data: 'stackholder', name: 'stackholder' }, // Kolom Stakeholder
                { data: 'nama_lulusan', name: 'nama_lulusan' }, // Kolom Nama Lulusan
                { data: 'program_studi', name: 'program_studi' }, // Kolom Program Studi
            ]
        });
    });
</script>
@endpush