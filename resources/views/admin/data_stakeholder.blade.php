@extends('layouts.app')

@section('title', 'Table')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Stakeholder</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Data Stakeholder</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Stakeholder</h4>
                                <div class="card-header-form">
                                    {{-- <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table_instansi">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Atasan</th>
                                                <th>Stakeholder</th>
                                                <th>Nama Lulusan</th>
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
            var dataInstansi = $('#table_instansi').DataTable({
                // Menggunakan server-side processing jika diperlukan
                serverSide: true,
                ajax: {
                    "url": "{{ url('instansi/list') }}", // URL untuk mengambil data
                    "dataType": "json",
                    "type": "GET",
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
                        // Nama instansi
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        // Instansi
                        data: "instansi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        // Nama dari lulusan (misalnya)
                        data: "nama_lulusan", // Gantilah sesuai dengan nama kolom yang sesuai di server
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        // Aksi seperti Edit, Hapus dll.
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