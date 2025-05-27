@extends('layouts.app')

@section('title', 'Data Alumni')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Alumni</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Alumni</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="alumni-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Program Studi</th>
                                                <th>Instansi</th>
                                                <th>Profesi</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- DataTables will populate this dynamically -->
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
    <script>
        $(document).ready(function () {
            // Initialize DataTable with AJAX source
            $('#alumni-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.alumni.data') }}', // Correct AJAX route to fetch alumni data
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Index column (Automatically populated by addIndexColumn)
                    { data: 'nama', name: 'nama' }, // Alumni Name
                    { data: 'program_studi', name: 'program_studi' }, // Program Studi
                    { data: 'instansi', name: 'instansi' }, // Instansi
                    { data: 'kategori_profesi', name: 'kategori_profesi' }, // Kategori Profesi
                    { data: 'action', name: 'action', orderable: false, searchable: false } // Actions (Edit/Delete)
                ],
                order: [[1, 'asc']]  // Optional: Set default sorting order
            });

        });
    </script>
    <!-- JS Libraies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
@endpush