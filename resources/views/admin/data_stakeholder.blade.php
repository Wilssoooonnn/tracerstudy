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
                            <div class="card-body p-0">
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
    $(document).ready(function() {
        var dataInstansi = $('#table_instansi').DataTable({ 
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('instansi/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama",
                    className: "",
                    orderable: true,
                    searchable: true, //jika ingin kolom ini bisa dicari
                }, {
                    data: "instansi",
                    className: "",
                    orderable: true,
                    searchable: true, //jika ingin kolom ini bisa dicari
                }, {
                    data: "alumni_id",
                    className: "",
                    orderable: true,
                    searchable: true, //jika ingin kolom ini bisa dicari
                }, {
                    data: "action",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            })
        });
    </script>
@endpush
