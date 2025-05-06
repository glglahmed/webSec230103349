<!-- resources/views/users/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>Edit User</h1>

        <!-- تحقق إن المستخدم المستهدف مش Admin لو اللي بيعدّل هو Employee -->
        @if (auth()->user()->hasRole('Employee') && $user->hasRole('Admin'))
            <div class="alert alert-danger">
                You are not allowed to edit an Admin user.
            </div>
            <a href="{{ route('users_list') }}" class="btn btn-secondary">Back to Users</a>
        @else
            <!-- عرض رسايل الخطأ -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- عرض رسالة النجاح لو موجودة -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- فورم تعديل المستخدم -->
            <form method="POST" action="{{ route('users_save') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (Leave blank to keep unchanged)</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small class="form-text text-muted">Password must be at least 8 characters long if provided.</small>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Roles</label>
                    <select name="roles[]" id="roles" class="form-control" multiple required>
                        @foreach (Spatie\Permission\Models\Role::all() as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <a href="#" onclick="document.getElementById('roles').selectedIndex = -1;">(reset)</a>
                </div>

                <div class="mb-3">
                    <label for="permissions" class="form-label">Direct Permissions</label>
                    <select name="permissions[]" id="permissions" class="form-control" multiple>
                        @foreach (Spatie\Permission\Models\Permission::all() as $permission)
                            <option value="{{ $permission->name }}" {{ $user->hasDirectPermission($permission->name) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </select>
                    <a href="#" onclick="document.getElementById('permissions').selectedIndex = -1;">(reset)</a>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('users_list') }}" class="btn btn-secondary">Back</a>
            </form>
        @endif
    </div>
</body>
</html>