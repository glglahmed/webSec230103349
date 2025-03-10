@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome to the Dashboard</h2>
    <p>You are logged in successfully!</p>
    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
</div>
@endsection
