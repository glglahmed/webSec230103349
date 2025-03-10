<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Simple Calculator</h2>
    <div class="card p-4">
        <div class="mb-3">
            <label for="num1" class="form-label">Enter first number:</label>
            <input type="number" id="num1" class="form-control">
        </div>
        <div class="mb-3">
            <label for="num2" class="form-label">Enter second number:</label>
            <input type="number" id="num2" class="form-control">
        </div>
        <div class="mb-3">
            <label for="operation" class="form-label">Select operation:</label>
            <select id="operation" class="form-select">
                <option value="add">Addition (+)</option>
                <option value="subtract">Subtraction (-)</option>
                <option value="multiply">Multiplication (*)</option>
                <option value="divide">Division (/)</option>
            </select>
        </div>
        <button onclick="calculate()" class="btn btn-primary">Calculate</button>
        <h4 class="mt-3">Result: <span id="result"></span></h4>
    </div>
</div>

<script>
    function calculate() {
        let num1 = parseFloat(document.getElementById("num1").value);
        let num2 = parseFloat(document.getElementById("num2").value);
        let operation = document.getElementById("operation").value;
        let result;

        if (isNaN(num1) || isNaN(num2)) {
            result = "Please enter valid numbers";
        } else {
            switch (operation) {
                case "add":
                    result = num1 + num2;
                    break;
                case "subtract":
                    result = num1 - num2;
                    break;
                case "multiply":
                    result = num1 * num2;
                    break;
                case "divide":
                    result = num2 !== 0 ? num1 / num2 : "Cannot divide by zero";
                    break;
                default:
                    result = "Invalid operation";
            }
        }

        document.getElementById("result").textContent = result;
    }
</script>

</body>
</html>
