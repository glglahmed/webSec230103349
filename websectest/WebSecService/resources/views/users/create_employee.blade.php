@extends('layouts.master')

@section('content')
    <h1>Create Employee</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="POST" action="{{ route('users_store_employee') }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password_confirmation" class="col-sm-2 col-form-label">Password Confirmation:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Employee</button>
    </form>
@endsection