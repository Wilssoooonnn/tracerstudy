@extends('layouts.app')

@section('title', 'Table')

@push('style')
<!-- CSS Libraries -->
@endpush
    
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Hasil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Tracer Study Lulusan</div>
                </div>
            </div>

             <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekap Hasil Tracer Study Lulusan</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group w-auto">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-file-export"></i> Export Data
                                                </button>
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
                                            <th>Nama</th>
                                            <th>Instansi</th>
                                            <th>Nama Lulusan</th>
                                            <th>Program Studi</th>
                                            <th>Tahun Lulus</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Annisa</td>
                                            <td>PT. OTSUKA</td>
                                            <td>Nasya</td>
                                            <td>D4 - SIB</td>
                                            <td>2025</td>
                                            <td><a href="#" class="btn btn-primary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Kirana Salsabilla</td>
                                            <td>PT. Jungan 99</td>
                                            <td>Fasya Dita Nasahah</td>
                                            <td>D4 - SIB</td>
                                            <td>2026</td>
                                            <td><a href="#" class="btn btn-primary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Hezakiel Ahmad</td>
                                            <td>PT. Niko Elektronik</td>
                                            <td>Adam Nur Alifi</td>
                                            <td>D4 - SIB</td>
                                            <td>2027</td>
                                            <td><a href="#" class="btn btn-primary">Detail</a></td>
                                        </tr>
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