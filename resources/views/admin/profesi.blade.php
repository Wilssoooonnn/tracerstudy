@extends('layouts.app')

@section('title', 'Table')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengelolaan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Pengelolaan Profesi</div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="card-header">
                                <h4>Pengelolaan Profesi</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="ml-3" >
                                                <a href="{{ url('/profesi/create') }}" class="btn btn-success">
                                                    Create
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table_profesi">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Profesi</th>
                                                <th>Action</th>
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
            var dataProfesi = $('#table_profesi').DataTable({
                // Menggunakan server-side processing jika diperlukan
                serverSide: true,
                ajax: {
                    "url": "{{ url('profesi/list') }}", // URL untuk mengambil data
                    "dataType": "json",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Menambahkan token CSRF
                    }
                },
                columns: [
                    {
                        // Menambahkan nomor urut
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "category_id",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "profesi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "action",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

    </script>
@endpush