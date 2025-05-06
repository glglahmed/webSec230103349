@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<div class="d-flex justify-content-center">
    <div class="card m-4 col-sm-6">
        <div class="card-body">
            <h2>Reset Password</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{$error}}
                </div>
            @endforeach
            <form action="{{ route('password.update') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group mb-2">
                    <label for="password" class="form-label">New Password:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection