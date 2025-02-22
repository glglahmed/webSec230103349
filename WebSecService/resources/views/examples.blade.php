@extends('layouts.master')

@section('content')
    <h1>Welcome to the Examples Page</h1>

    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#multiplication">Multiplication Table</a></li>
                <li class="nav-item"><a class="nav-link" href="#prime-normal">Prime Numbers (Normal)</a></li>
                <li class="nav-item"><a class="nav-link" href="#prime-helper">Prime Numbers (Helper)</a></li>
                <li class="nav-item"><a class="nav-link" href="#even-numbers">Even Numbers</a></li>
                <li class="nav-item"><a class="nav-link" href="#js-demo">JavaScript Demo</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div id="multiplication" class="card m-4">
            <div class="card-header bg-primary text-white">Multiplication Table</div>
            <div class="card-body">
                <table class="table table-bordered">
                    @for ($i = 1; $i <= 10; $i++)
                        <tr>
                            @for ($j = 1; $j <= 10; $j++)
                                <td>{{ $i * $j }}</td>
                            @endfor
                        </tr>
                    @endfor
                </table>
            </div>
        </div>
                <!--  prime-normal -->
        <div id="prime-normal" class="card m-4">
            <div class="card-header bg-danger text-white">Prime Numbers (Normal)</div>
            <div class="card-body">
                @php
                    function isPrimeLocal($num) {
                        if ($num < 2) return false;
                        for ($i = 2; $i <= sqrt($num); $i++) {
                            if ($num % $i == 0) return false;
                        }
                        return true;
                    }
                @endphp
                @foreach (range(1, 100) as $i)
                    @if (isPrimeLocal($i))
                        <span class="badge bg-primary">{{ $i }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $i }}</span>
                    @endif
                @endforeach
            </div>
        </div>
                    <!--  prime-helper -->
        <div id="prime-helper" class="card m-4">
            <div class="card-header bg-success text-white">Prime Numbers (Helper Function)</div>
            <div class="card-body">
                @foreach (range(1, 100) as $i)
                    @if (isPrime($i))
                        <span class="badge bg-primary">{{ $i }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $i }}</span>
                    @endif
                @endforeach
            </div>
        </div>
                    <!-- even number  -->
        <div id="even-numbers" class="card m-4">
            <div class="card-header bg-info text-white">Even Numbers</div>
            <div class="card-body">
                @foreach (range(1, 100) as $i)
                    @if ($i % 2 == 0)
                        <span class="badge bg-primary">{{ $i }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $i }}</span>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- JavaScript  -->
        <div id="js-demo" class="card m-4">
            <div class="card-header bg-warning text-white">JavaScript Example</div>
            <div class="card-body">
                <button type="button" class="btn btn-primary" onclick="doSomething()">Press Me</button>
            </div>
        </div>

    </div>

    <script>
        function doSomething() {
            alert("Hello from JavaScript");
        }
    </script>
@endsection
