<!-- resources/views/admin/profile.blade.php -->
@extends('layouts.main')
@section('content')
    <div class="container mt-5">
        <h1>Profile</h1>
        <p>Name: {{ Auth::guard('admin')->user()->name }}</p>
        <p>Username: {{ Auth::guard('admin')->user()->username }}</p>
    </div>
@endsection