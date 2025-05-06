<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic Website - @yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        @yield('content')
    </div>
    @if (auth()->check() && auth()->user()->hasRole('Admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('activity_logs') }}">Activity Logs</a>
    </li>
@endif
</body>
</html>