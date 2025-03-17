@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Grades List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Credit Hours</th>
                <th>Grade</th>
                <th>Term</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->course_name }}</td>
                    <td>{{ $grade->course_code }}</td>
                    <td>{{ $grade->credit_hours }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $grade->term }}</td>
                    <td>
                        <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total Credit Hours: {{ $totalCreditHours }}</h4>
    <h4>GPA: {{ number_format($gpa, 2) }}</h4>

    <a href="{{ route('grades.create') }}" class="btn btn-primary mt-3">Add New Grade</a>
</div>
@endsection
