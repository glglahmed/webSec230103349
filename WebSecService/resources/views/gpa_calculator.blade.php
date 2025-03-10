<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">GPA Calculator</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Title</th>
                <th>Credit Hours</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course['code'] }}</td>
                <td>{{ $course['title'] }}</td>
                <td>{{ $course['credit_hours'] }}</td>
                <td>
                    <input type="number" class="form-control grade" data-credits="{{ $course['credit_hours'] }}" min="0" max="4" step="0.1">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="calculateGPA()" class="btn btn-primary">Calculate GPA</button>
    <h4 class="mt-3">Your GPA: <span id="gpa_result"></span></h4>
</div>

<script>
    function calculateGPA() {
        let totalCredits = 0, totalPoints = 0;
        
        document.querySelectorAll('.grade').forEach(input => {
            let grade = parseFloat(input.value) || 0;
            let credits = parseInt(input.dataset.credits);
            
            totalPoints += grade * credits;
            totalCredits += credits;
        });

        let gpa = totalCredits ? (totalPoints / totalCredits).toFixed(2) : 0;
        document.getElementById("gpa_result").textContent = gpa;
    }
</script>

</body>
</html>
