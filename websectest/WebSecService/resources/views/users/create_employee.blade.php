@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
    <h1>Create Employee</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('store_employee') }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Create Employee</button>
                <a href="{{ route('users_list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
@endsection