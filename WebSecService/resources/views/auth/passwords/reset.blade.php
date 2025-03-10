@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reset Password</h2>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Reset Password</button>
    </form>
</div>
@endsection
