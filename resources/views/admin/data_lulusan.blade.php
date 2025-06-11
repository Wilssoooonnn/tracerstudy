@extends('layouts.app')

@section('title', 'Data Lulusan')

@push('style')
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
                                    <a href="{{ route('lulusan_import_view') }}" class="btn btn-primary">Import Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                                <th>Tahun Lulus</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#table-2').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('lulusan.data') }}',
                    type: 'GET',
                    error: function (xhr, error, thrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load data: ' + (xhr.responseJSON?.message || thrown),
                            confirmButtonText: 'OK'
                        });
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nim', name: 'nim' },
                    { data: 'nama', name: 'nama' },
                    { data: 'prodi', name: 'prodi' },
                    // { data: 'nohp', name: 'nohp' },
                    // { data: 'email', name: 'email' },
                    { data: 'tanggal_lulus', name: 'tanggal_lulus' },
                    { data: 'keterangan', name: 'keterangan' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        defaultContent: '<button class="btn btn-primary btn-sm" disabled>Kirim Token</button>'
                    }
                ],
                language: {
                    emptyTable: "No data available in table",
                    processing: "Loading..."
                }
            });

            window.kirimToken = function (id) {
                Swal.fire({
                    title: 'Kirim Token?',
                    text: "Apakah Anda yakin ingin mengirimkan token ke alumni ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.generate-token', ':id') }}'.replace(':id', id),
                            method: 'POST',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    });
                                    table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message || 'Failed to send token.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'An error occurred while sending the token.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            };
        });
    </script>
@endpush