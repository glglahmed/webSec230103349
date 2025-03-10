@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, {{ $user->name }} 👋</h2>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>User ID:</strong> {{ $user->id }}</p>

    <a href="{{ route('change-password.form') }}" class="btn btn-primary">Change Password</a>
</div>
@endsection
