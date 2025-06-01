@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pertanyaan</h1>
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
                            <div class="card-header">
                                <h4>Tambah Pertanyaan</h4>
                            </div>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Pertanyaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ url('/pertanyaan') }}" class="form-horizontal">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="pertanyaan">Pertanyaan</label>
                                            <input type="text" name="pertanyaan" id="pertanyaan" class="form-control"
                                                required>
                                            <small id="error-pertanyaan" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-warning" href="{{ url('pertanyaan')}}">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection