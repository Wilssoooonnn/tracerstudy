@extends('layouts.app')

@section('title', 'Table')

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
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Response Stakeholder Terhadap Alumni</h4>
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
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Nama Instansi</th>
                                            <th>Nama Lulusan</th>
                                            <th>Program Studi</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Nama Stakeholder</td>
                                            <td>Nama Instansi</td>
                                            <th>Nama Lulusan</th>
                                            <th>Program Studi</th>
                                            <td>
                                                <a href="#" class="btn btn-primary">
                                                    <i class="fa fa-link"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Tambahkan baris berikutnya di sini -->
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
