@extends('layouts.app')

@section('title', 'Edit Question')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Question</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Edit Question</div>
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
                                <h4>Edit Question</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/pertanyaan/' . $pertanyaan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Use PUT method to update the existing record -->

                                    <!-- Question Text -->
                                    <div class="form-group">
                                        <label for="pertanyaan">Question</label>
                                        <textarea class="form-control" name="pertanyaan" rows="3"
                                            required>{{ $pertanyaan->pertanyaan }}</textarea>
                                    </div>

                                    <!-- Question Type (Scale or Text) -->
                                    <div class="form-group">
                                        <label for="question_type">Question Type</label>
                                        <select name="question_type" class="form-control" required>
                                            <option value="scale" {{ $pertanyaan->question_type == 'scale' ? 'selected' : '' }}>Scale (1-5)</option>
                                            <option value="text" {{ $pertanyaan->question_type == 'text' ? 'selected' : '' }}>
                                                Text (Open-ended)</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Question</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection