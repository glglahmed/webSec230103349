@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Grade</h2>

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Grade</label>
            <input type="number" name="grade" class="form-control" step="0.01" min="0" max="4" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Term</label>
            <input type="number" name="term" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
