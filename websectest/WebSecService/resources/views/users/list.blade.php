<!-- resources/views/users/list.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>Users</h1>
        
        @if (auth()->user()->hasRole('Admin'))
             <div class="mb-3">
             <a href="{{ route('create_employee') }}" class="btn btn-primary">Add Employee</a>
             </div>
         @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('users_list') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="keywords" class="form-control" placeholder="Search Keywords" value="{{ request('keywords') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('users_list') }}" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if (auth()->user()->hasPermissionTo('edit_users'))
                                <a href="{{ route('users_edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('delete_users'))
                                <form action="{{ route('users_delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                            @if (auth()->user()->hasPermissionTo('add_credit_to_customers'))
                                @if ($user->hasRole('Customer') && !$user->hasRole('Admin') && !$user->hasRole('Employee'))
                                    <form action="{{ route('users_add_credit', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="number" name="credit" min="0" placeholder="Add Credit" class="form-control d-inline-block w-auto" required>
                                        <button type="submit" class="btn btn-success btn-sm">Add Credit</button>
                                    </form>
                                @else
                                    <span class="text-muted">Not a customer</span>
                                @endif
                            @endif
                            @if (auth()->user()->hasPermissionTo('reset_credit'))
        @if ($user->hasRole('Customer') && !$user->hasRole('Admin') && !$user->hasRole('Employee'))
            <form action="{{ route('reset_credit', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to reset this customer\'s credit to 0?')">Reset</button>
            </form>
        @endif
    @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</body>
</html>