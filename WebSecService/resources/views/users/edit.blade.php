@extends('layouts.app')

@section('content')
<div class="container">
    <h1> Edit user</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="admin" class="form-label">مسؤول</label>
            <input type="checkbox" name="admin" value="1" {{ $user->admin ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection