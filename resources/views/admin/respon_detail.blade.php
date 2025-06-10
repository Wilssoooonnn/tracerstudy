@extends('layouts.app')

@section('title', 'Detail Respon')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Respon Stakeholder</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6><strong>Nama Stakeholder:</strong></h6>
                                <p>{{ $stakeholder->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Instansi:</strong></h6>
                                <p>{{ $stakeholder->instansi }}</p>
                            </div>
                        </div>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Respon (Skala)</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penilaian as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item['pertanyaan'] }}</td>
                                        <td>{{ $item['nilai'] }}</td>
                                        <td>{{ $item['keterangan'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data respon.</td>
                                    </tr>
                                @endforelse
                            </tbody>                            
                        </table>
                    </div>

                    <a href="{{ route('response.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

