@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Grade</h2>

    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" value="{{ $grade->course_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" value="{{ $grade->course_code }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" value="{{ $grade->credit_hours }}" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Grade</label>
            <input type="number" name="grade" class="form-control" step="0.01" min="0" max="4" value="{{ $grade->grade }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Term</label>
            <input type="number" name="term" class="form-control" min="1" value="{{ $grade->term }}" required>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
