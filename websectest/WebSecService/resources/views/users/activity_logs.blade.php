@extends('layouts.master')

@section('title', 'Activity Logs')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Activity Logs</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (count($logs) > 0)
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Recent Activities</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->user ? $log->user->name : 'N/A' }}</td>
                                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No activities found.
        </div>
    @endif
</div>
@endsection