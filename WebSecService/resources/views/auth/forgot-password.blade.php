

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Forgot Password</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Enter your email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Send Password Reset Link</button>
    </form>
</div>
@endsection
