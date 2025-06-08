@extends('layouts.app')

@section('title', 'Detail Rekap Hasil Survey Kepuasan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Rekap Hasil Survey Kepuasan</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if (isset($stakeholder))
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <h6><strong>Nama Stakeholder:</strong></h6>
                                    <p>{{ $stakeholder->nama }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6><strong>Instansi:</strong></h6>
                                    <p>{{ $stakeholder->instansi }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6><strong>Nama Alumni:</strong></h6>
                                    <p>{{ $stakeholder->lulusan->nama ?? '-' }}</p>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Nilai</th>
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

                        <a href="{{ url('admin/rekap-hasil-surveykepuasan') }}"
                            class="btn btn-sm btn-danger mt-2">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
