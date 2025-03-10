<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Transcript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Student Transcript</h2>

        <div class="mb-3">
            <strong>Student Name:</strong> {{ $student['name'] }} <br>
            <strong>Student ID:</strong> {{ $student['id'] }} <br>
            <strong>Department:</strong> {{ $student['department'] }} <br>
            <strong>Total GPA:</strong> {{ number_format($totalGPA, 2) }} <!-- توتال GPA يظهر هنا -->
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Course</th>
                    <th>GPA</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student['courses'] as $course)
                <tr>
                    <td>{{ $course['name'] }}</td>
                    <td>{{ number_format($course['gpa'], 2) }}</td>
                    <td>{{ $course['grade'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
