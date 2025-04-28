@extends('layouts.master')

@section('title', 'Even Numbers')

@section('content')
<div class="container mt-5">
    <div class="card shadow m-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Even Numbers (1 to 100)</h4>
            <button id="toggleOdd" class="btn btn-light btn-sm">Toggle Odd Numbers</button>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach (range(1, 100) as $i)
                    <div class="col-1 p-1 number {{ $i % 2 == 0 ? 'even' : 'odd' }}">
                        <span class="badge w-100 {{ $i % 2 == 0 ? 'bg-primary' : 'bg-secondary' }}">{{ $i }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('toggleOdd').addEventListener('click', function () {
        const oddNumbers = document.querySelectorAll('.odd');
        oddNumbers.forEach(number => {
            number.style.display = number.style.display === 'none' ? 'block' : 'none';
        });
        this.textContent = this.textContent === 'Toggle Odd Numbers' ? 'Show Odd Numbers' : 'Toggle Odd Numbers';
    });
</script>
@endsection
@endsection