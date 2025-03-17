@extends('layouts.app')

@section('content')
    <h2>Edit User</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}" required>
        <input type="email" name="email" value="{{ $user->email }}" required>
        <label>
            Admin:
            <input type="checkbox" name="admin" {{ $user->admin ? 'checked' : '' }}>
        </label>
        <button type="submit">Update</button>
    </form>

    <h3>Change Password</h3>
    <form action="{{ route('admin.users.changePassword', $user) }}" method="POST">
        @csrf
        <input type="password" name="old_password" placeholder="Old Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit">Change Password</button>
    </form>
@endsection
