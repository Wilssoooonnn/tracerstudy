@extends('layouts.app')

@section('title', 'Create Question')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create a New Question</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Create Profession</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="card-header">
                                <h4>Create a New Profession</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/profesi') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="category_type">Category Type</label>
                                        <select name="category_type" class="form-control" required>
                                            <option value="" disabled>Select Category Type</option>
                                            <option value="1">Bidang Infokom</option>
                                            <option value="2">Bidang Non Infokom</option>
                                        </select>
                                    </div>

                                    <!-- Question Text -->
                                    <div class="form-group">
                                        <label for="profesi">Profession</label>
                                        <textarea class="form-control" name="profesi" rows="3" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Profession</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection