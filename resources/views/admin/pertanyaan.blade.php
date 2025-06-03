@extends('layouts.app')

@section('title', 'Pertanyaan')

@push('style')
    <!-- Add any custom CSS libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pertanyaan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Pertanyaan</div>
                </div>
            </div>

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
                                <h4>Daftar Pertanyaan</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="ml-3">
                                                <a href="{{ url('/pertanyaan/create') }}" class="btn btn-success">
                                                    Create New Question
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table_pertanyaan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pertanyaan</th>
                                                <th>Type</th>
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
    <!-- Include JS Libraries -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var dataPertanyaan = $('#table_pertanyaan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('pertanyaan/list') }}",
                    dataType: "json",
                    type: "POST"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "pertanyaan",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: "question_type",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    }
                ]
            })
        });
    </script>
@endpush