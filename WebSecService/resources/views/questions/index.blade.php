@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Questions</h2>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">Add New Question</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Options</th>
            <th>Correct Answer</th>
            <th>Actions</th>
        </tr>
        @foreach ($questions as $question)
        <tr>
            <td>{{ $question->id }}</td>
            <td>{{ $question->question_text }}</td>
            <td>
                A) {{ $question->option_a }} <br>
                B) {{ $question->option_b }} <br>
                C) {{ $question->option_c }} <br>
                D) {{ $question->option_d }}
            </td>
            <td>{{ strtoupper(str_replace('option_', '', $question->correct_option)) }}</td>
            <td>
                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
