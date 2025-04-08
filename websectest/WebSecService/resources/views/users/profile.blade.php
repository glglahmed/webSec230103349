@extends('layouts.master')

@section('title', 'User Profile')

@section('content')
    <div class="row">
        <div class="m-4 col-sm-6">
            <h1>User Profile</h1>

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

            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Credit</th>
                    <td>{{ $user->credit }}</td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        @foreach($permissions as $permission)
                            <span class="badge bg-success">{{ $permission->display_name ?? $permission->name }}</span>
                        @endforeach
                    </td>
                </tr>
            </table>

            <div class="row">
                <div class="col col-6">
                </div>
                @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                    <div class="col col-4">
                        <a class="btn btn-primary" href="{{ route('edit_password', $user->id) }}">Change Password</a>
                    </div>
                @else
                    <div class="col col-4">
                    </div>
                @endif
                @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                    <div class="col col-2">
                        <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success form-control">Edit</a>
                    </div>
                @endif
            </div>

            @if($user->hasRole('Customer') && $purchases->isNotEmpty())
                <h3 class="mt-4">Purchase History</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->product->name }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->total_price }}</td>
                                <td>{{ $purchase->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection