<!-- resources/views/users/forget_password.blade.php -->
@extends('layouts.master')
@section('title', 'Forget Password')
@section('content')
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <h2>Forget Password</h2>

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

      <form action="{{ route('password.email') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group mb-2">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
        </div>
        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Send Temporary Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection