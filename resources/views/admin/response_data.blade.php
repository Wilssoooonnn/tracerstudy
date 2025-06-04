@extends('layouts.app')

@section('title', 'Response Data')

@push('style')
    <!-- CSS Libraries --> 
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Response Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Response Data</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Response Stakeholder Terhadap Alumni</h4>
                            </div>
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="tableRespon">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Stakeholder</th>
                                                <th>Nama Instansi</th>
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
        var dataRespon = $('#tableRespon').DataTable({
            serverSide: true, // Enable server-side processing
            ajax: {
                "url": "{{ url('response/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns: [{
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false, // Disable ordering for this column
                searchable: false // Disable searching for this column
            }, {
                data: "nama_stakeholder",
                className: "",
                orderable: true, // Enable ordering for this column
                searchable: true // Enable searching for this column
            },{
                data: "nama_instansi",
                className: "",
                orderable: true, // Enable ordering for this column
                searchable: true // Enable searching for this column
            },{
                data: "action",
                className: "",
                orderable: false,
                searchable: false
            }]
        });
    });
</script>
@endpush
