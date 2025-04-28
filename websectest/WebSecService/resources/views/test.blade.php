@extends('layouts.master')

@section('title', 'Test Page')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Users List (Test Page)</h2>

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

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">All Users</h4>
        </div>
        <div class="card-body">
            @if (count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->hasRole('Admin'))
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif ($user->hasRole('Employee'))
                                            <span class="badge bg-warning">Employee</span>
                                        @elseif ($user->hasRole('Customer'))
                                            <span class="badge bg-success">Customer</span>
                                        @else
                                            <span class="badge bg-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('profile', $user->id) }}" class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    No users found.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection