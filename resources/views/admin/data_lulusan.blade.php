@extends('layouts.app')

@section('title', 'Data Lulusan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Lulusan</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Lulusan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                            data-checkbox-role="dad" class="custom-control-input"
                                                            id="checkbox-all">
                                                        <label for="checkbox-all"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#table-2').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: '{{ route('lulusan.data') }}', // Menyesuaikan rute yang mengembalikan data JSON
                columns: [
                    {
                        data: null,
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return '<div class="custom-checkbox custom-control"><input type="checkbox" class="custom-control-input" value="' + row.id + '" data-checkboxes="mygroup" name="id[]"><label for="checkbox-' + row.id + '" class="custom-control-label"></label></div>';
                        }
                    },
                    { data: 'id', name: 'id' },
                    { data: 'nim', name: 'nim' },
                    { data: 'nama', name: 'nama' },
                    { data: 'programs_id', name: 'programs_id' }, // Ini akan menampilkan nama program studi
                    { data: 'nohp', name: 'nohp' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Select/Deselect all checkboxes when the header checkbox is clicked
            $('#checkbox-all').on('change', function () {
                var isChecked = $(this).prop('checked');
                $('#table-2').find('tbody input[type="checkbox"]').each(function () {
                    $(this).prop('checked', isChecked);
                });
            });
        });
        $("#Detail").click(function () {
            swal('Hello');
        });
    </script>
@endpush