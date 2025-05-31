@extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Import Data Lulusan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table Lulusan</div>
            </div>
        </div>
        <form action="{{ url('/data-lulusan/import') }}" method="POST" id="form-import" enctype="multipart/form-data"> 
            @csrf 
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Import Data Lulusan</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Download Template</label>
                        <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm" download>
                            <i class="fa fa-file-excel"></i> Download
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

<script>
$(document).ready(function() {
    $("#form-import").validate({
        rules: {
            file_lulusan: {
                required: true,
                extension: "xlsx"
            },
        },
        submitHandler: function(form) {
            var formData = new FormData(form); // handle file upload

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            // Redirect ke halaman utama supaya data tabel ter-refresh
                            window.location.href = "{{ url('/data-lulusan') }}";
                        });

                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
