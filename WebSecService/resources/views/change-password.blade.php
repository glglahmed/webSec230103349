@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Change Password</h2>
    <form method="POST" action="{{ route('password.change') }}">
        @csrf
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>
@endsection
