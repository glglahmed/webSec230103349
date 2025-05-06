@extends('layouts.master')

@section('title', 'Prime Numbers')

@section('content')
<div class="container mt-5">
    <div class="card shadow m-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Prime Numbers (1 to 100)</h4>
            <button id="showPrimeOnly" class="btn btn-light btn-sm">Show Prime Only</button>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach (range(1, 100) as $i)
                    <div class="col-1 p-1 number {{ @isPrime($i) ? 'prime' : 'non-prime' }}">
                        <span class="badge w-100 {{ @isPrime($i) ? 'bg-primary' : 'bg-secondary' }}">{{ $i }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('showPrimeOnly').addEventListener('click', function () {
        const nonPrimeNumbers = document.querySelectorAll('.non-prime');
        nonPrimeNumbers.forEach(number => {
            number.style.display = number.style.display === 'none' ? 'block' : 'none';
        });
        this.textContent = this.textContent === 'Show Prime Only' ? 'Show All Numbers' : 'Show Prime Only';
    });
</script>
@endsection
@endsection