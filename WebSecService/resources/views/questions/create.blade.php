@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Question</h2>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <label>Question:</label>
        <input type="text" name="question_text" class="form-control" required>

        <label>Option A:</label>
        <input type="text" name="option_a" class="form-control" required>

        <label>Option B:</label>
        <input type="text" name="option_b" class="form-control" required>

        <label>Option C:</label>
        <input type="text" name="option_c" class="form-control" required>

        <label>Option D:</label>
        <input type="text" name="option_d" class="form-control" required>

        <label>Correct Answer:</label>
        <select name="correct_option" class="form-control" required>
            <option value="option_a">A</option>
            <option value="option_b">B</option>
            <option value="option_c">C</option>
            <option value="option_d">D</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>
@endsection
