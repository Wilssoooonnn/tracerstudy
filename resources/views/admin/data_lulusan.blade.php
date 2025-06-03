@extends('layouts.app')

@section('title', 'Data Lulusan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.css">
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
                                <div class="card-header-action">
                                    <a href="{{ route('lulusan_import_post') }}" class="btn btn-primary">Import Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                                <th>Phone</th>
                                                <th>Email</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#table-2').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('lulusan.data') }}', // Menyesuaikan rute yang mengembalikan data JSON
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nim', name: 'nim' },
                    { data: 'nama', name: 'nama' },
                    { data: 'prodi', name: 'prodi' },
                    { data: 'nohp', name: 'nohp' },
                    { data: 'email', name: 'email' },
                ]
            });

            // Menampilkan detail lulusan menggunakan SweetAlert
            function showDetail(id) {
                Swal.fire({
                    title: 'Detail Lulusan',
                    text: `Lulusan dengan ID: ${id}`,  // Sesuaikan dengan data yang lebih lengkap
                    icon: 'info'
                });
            }

        });
    </script>
@endpush