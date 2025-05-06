<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>Customers List</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->credit }}</td>
                        <td>
                            @if (auth()->user()->hasPermissionTo('add_credit_to_customers'))
                                <form method="POST" action="{{ route('users_add_credit', $customer->id) }}" style="display: inline-block;">
                                    @csrf
                                    <input type="number" name="credit" min="0" step="0.01" required placeholder="Add Credit">
                                    <button type="submit" class="btn btn-primary">Add Credit</button>
                                </form>
                            @endif
                            @if (auth()->user()->hasPermissionTo('make_payments'))
                                <form method="POST" action="{{ route('users_make_payment', $customer->id) }}" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to record a payment of ' + document.getElementsByName('amount')[0].value + ' for this customer?');">
                                    @csrf
                                    <input type="number" name="amount" min="0.01" max="{{ $customer->credit }}" step="0.01" required placeholder="Payment Amount">
                                    <button type="submit" class="btn btn-warning">Make Payment</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $customers->links() }}
    </div>
</body>
</html>