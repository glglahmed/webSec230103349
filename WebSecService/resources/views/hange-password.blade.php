<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('change.password') }}" method="POST">
        @csrf
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="new_password_confirmation">Confirm Password:</label>
        <input type="password" name="new_password_confirmation" required><br>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>
