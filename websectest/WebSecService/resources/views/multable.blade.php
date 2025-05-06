@extends('layouts.master')

@section('title', 'Multiplication Table')

@section('content')
<div class="container mt-5">
    <div class="card shadow m-4 col-sm-6 mx-auto">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Multiplication Table</h4>
        </div>
        <div class="card-body">
            <!-- نموذج لاختيار الرقم -->
            <form method="GET" action="{{ route('multable') }}" class="mb-4">
                <div class="input-group">
                    <input type="number" name="number" class="form-control" value="{{ $j }}" min="1" max="20" placeholder="Enter a number">
                    <button type="submit" class="btn btn-primary">Generate Table</button>
                </div>
            </form>

            <h5 class="text-center mb-3">Table of {{ $j }}</h5>
            <table class="table table-bordered table-striped">
                @foreach (range(1, 10) as $i)
                    <tr class="{{ $i % 2 == 0 ? 'table-light' : 'table-info' }}">
                        <td>{{ $i }} × {{ $j }}</td>
                        <td>=</td>
                        <td>{{ $i * $j }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection