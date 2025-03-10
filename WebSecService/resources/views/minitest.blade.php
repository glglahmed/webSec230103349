<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniTest - Supermarket Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Supermarket Bill</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bill as $item)
                <tr>
                    <td>{{ $item['item'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    <th colspan="3" class="text-end">Total:</th>
                    <th>
                        ${{ number_format(collect($bill)->sum(fn($item) => $item['quantity'] * $item['price']), 2) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
