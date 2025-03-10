@extends('layouts.app')

@section('content')
<div class="container">
    <h1>users list </h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email </th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection