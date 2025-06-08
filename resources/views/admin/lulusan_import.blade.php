@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Import Data Lulusan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Import Data Lulusan</div>
                </div>
            </div>

            <form action="{{ route('lulusan_import_post') }}" method="POST" id="form-import" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Import Data Lulusan</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Download Template</label>
                            <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm" download>
                                <i class="fa fa-file-excel"></i> Download Template
                            </a>
                            <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Pilih File</label>
                            <input type="file" name="file_lulusan" id="file_lulusan" class="form-control" required>
                            <small id="error-file_lulusan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        // Tangani proses upload file
        $('#form-import').on('submit', function (e) {
            e.preventDefault();  // Cegah form dari pengiriman normal

            var formData = new FormData(this);  // Ambil form data

            // Ajax request untuk mengirim data form ke server
            $.ajax({
                url: '{{ route('lulusan_import_post') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Menampilkan SweetAlert sesuai dengan status response
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then((result) => {
                            // Jika berhasil, arahkan ke halaman data lulusan
                            window.location.href = '{{ route('admin.data-lulusan') }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Tidak dapat memproses file.',
                    });
                }
            });
        });
    });
</script>