@extends('layouts.app')

@section('title', 'Table Rekap Belum Isi')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Belum Mengisi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Rekap Belum Isi Form Lulusan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekap Belum Mengisi Lulusan</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="ml-3">
                                                <a href="{{ url('/rekaplulusan/export_excel') }}" class="btn btn-primary">
                                                    <i class="fa fa-file-excel"></i> 
                                                    Export Data
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="tableRekapLulusan">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
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
        $(document).ready(function () {
            var table1 = $('#tableRekapLulusan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('rekaplulusan/list') }}",
                    "dataType": "json",
                    "type": "POST"
                }, // Menyesuaikan rute yang mengembalikan data JSON
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nim', name: 'nim' },
                    { data: 'nama', name: 'nama' },
                    { data: 'prodi', name: 'prodi' },
                ]
            });
        });
    </script>
@endpush