@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">GPA Simulator</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Title</th>
                            <th>Credits</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody id="courseTable">
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $course['code'] }}</td>
                            <td>{{ $course['title'] }}</td>
                            <td>{{ $course['credits'] }}</td>
                            <td>
                                <input type="number" class="form-control grade-input" data-credits="{{ $course['credits'] }}" min="0" max="100">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button onclick="calculateGPA()" class="btn btn-primary w-100">Calculate GPA</button>
                <div class="alert alert-success text-center mt-3" id="gpaResult">GPA: N/A</div>
            </div>
        </div>
    </div>
</div>

<script>
function calculateGPA() {
    let totalCredits = 0, totalPoints = 0;
    document.querySelectorAll('.grade-input').forEach(input => {
        let grade = parseFloat(input.value);
        let credits = parseFloat(input.dataset.credits);
        if (!isNaN(grade)) {
            totalCredits += credits;
            totalPoints += credits * convertGradeToGPA(grade);
        }
    });

    let gpa = totalCredits > 0 ? (totalPoints / totalCredits).toFixed(2) : "N/A";
    document.getElementById("gpaResult").innerHTML = "GPA: " + gpa;
}

function convertGradeToGPA(grade) {
    if (grade >= 90) return 4.0;
    if (grade >= 85) return 3.7;
    if (grade >= 80) return 3.3;
    if (grade >= 75) return 3.0;
    if (grade >= 70) return 2.7;
    if (grade >= 65) return 2.3;
    if (grade >= 60) return 2.0;
    return 0.0;
}
</script>
@endsection
