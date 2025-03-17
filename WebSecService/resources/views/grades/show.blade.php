@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Grade Details</h2>

    <table class="table table-bordered">
        <tr>
            <th>Course Name</th>
            <td>{{ $grade->course_name }}</td>
        </tr>
        <tr>
            <th>Course Code</th>
            <td>{{ $grade->course_code }}</td>
        </tr>
        <tr>
            <th>Credit Hours</th>
            <td>{{ $grade->credit_hours }}</td>
        </tr>
        <tr>
            <th>Grade</th>
            <td>{{ $grade->grade }}</td>
        </tr>
        <tr>
            <th>Term</th>
            <td>{{ $grade->term }}</td>
        </tr>
    </table>

    <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
