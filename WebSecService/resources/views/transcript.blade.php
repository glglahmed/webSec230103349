@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Student Transcript</h2>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Course</th>
                <th>Grade</th>
                <th>Credits</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transcript as $course)
            <tr>
                <td>{{ $course['course'] }}</td>
                <td>{{ $course['grade'] }}</td>
                <td>{{ $course['credits'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="table-warning">
            <tr>
                <td colspan="2" class="text-end"><strong>Total Credits:</strong></td>
                <td><strong>{{ array_sum(array_column($transcript, 'credits')) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
