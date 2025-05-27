@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Lulusan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table Data Lulusan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Alumni Table</h4>
                                <!-- Align Add Alumni button to the right -->
                                <div class="card-header-form ml-auto">
                                    <a href="#" class="btn btn-primary">Add Alumni</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Survey Link Success Message -->
                                @if(session('link'))
                                    <div class="alert alert-success">
                                        Survey Link: <a href="{{ session('link') }}" target="_blank">{{ session('link') }}</a>
                                    </div>
                                @endif

                                <!-- Table Responsive Section -->
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                            data-checkbox-role="dad" class="custom-control-input"
                                                            id="checkbox-all">
                                                        <label for="checkbox-all"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Survey Link</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($alumni as $alum)
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox"
                                                                data-checkboxes="mygroup"
                                                                class="custom-control-input"
                                                                id="checkbox-{{ $alum->id }}">
                                                            <label for="checkbox-{{ $alum->id }} "
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $alum->id }}</td>
                                                    <td>{{ $alum->name }}</td>
                                                    <td>{{ $alum->email }}</td>
                                                    <td>
                                                        @if($alum->survey_token)
                                                            <a href="{{ route('survey.show', $alum->survey_token) }}" target="_blank">Link</a>
                                                            | <a href="#">Regenerate</a>
                                                        @else
                                                            <a href="#">Generate Link</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="badge {{ $alum->survey_completed ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $alum->survey_completed ? 'Completed' : 'Pending' }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>  

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
