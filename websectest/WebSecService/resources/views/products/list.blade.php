{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>Products</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (auth()->check() && auth()->user()->hasRole('Customer'))
            <p>Your Credit: {{ $credit }}</p>
        @endif

        <form method="GET" action="{{ route('products_list') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="keywords" class="form-control" placeholder="Search Keywords" value="{{ request('keywords') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <select name="order_by" class="form-control">
                        <option value="">Order By</option>
                        <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="name" {{ request('order_by') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order_direction" class="form-control">
                        <option value="ASC" {{ request('order_direction') == 'ASC' ? 'selected' : '' }}>Ascending</option>
                        <option value="DESC" {{ request('order_direction') == 'DESC' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('products_list') }}" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        @if (auth()->user()->hasPermissionTo('add_products'))
            <a href="{{ route('products_edit', 0) }}" class="btn btn-success mb-3">Add Product</a>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if ($product->photo)
                                <img src="{{ asset('images/' . $product->photo) }}" alt="{{ $product->name }}" width="50">
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>
                            @if (auth()->user()->hasPermissionTo('edit_products'))
                                <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('delete_products'))
                                <form action="{{ route('products_delete', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                            @if (auth()->user()->hasRole('Customer'))
                                <form action="{{ route('products_purchase', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Buy</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- {{ $products->links() }} --}}
    {{-- </div>
</body>
</html> --}} 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>Product List</h1>
        <p>Credit: {{ $credit }}</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('products_list') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="keywords" class="form-label">Search by Name or Code</label>
                    <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search Keywords" value="{{ request('keywords') }}">
                </div>
                <div class="col-md-2">
                    <label for="min_price" class="form-label">Min Price</label>
                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_price" class="form-label">Max Price</label>
                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <label for="order_by" class="form-label">Order By</label>
                    <select name="order_by" id="order_by" class="form-control">
                        <option value="id" {{ request('order_by') == 'id' ? 'selected' : '' }}>ID</option>
                        <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="name" {{ request('order_by') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="order_direction" class="form-label">Order Direction</label>
                    <select name="order_direction" id="order_direction" class="form-control">
                        <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-2 mt-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="col-md-2 mt-4">
                    <a href="{{ route('products_list') }}" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </form>

        @if (request('keywords'))
            <p class="mt-3">You searched for: {!! request('keywords') !!}</p>
        @endif

        @if (auth()->user()->hasPermissionTo('add_products'))
            <a href="{{ route('products_edit', 0) }}" class="btn btn-success mb-3">Add Product</a>
        @endif

        @if (auth()->check() && auth()->user()->hasRole('Customer'))
            <h3 class="mt-4">Request a Product</h3>
            <form method="POST" action="{{ route('products_list') }}">
                @csrf
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form>

            @if (!empty($requests))
                <h4 class="mt-3">Your Requests:</h4>
                @foreach ($requests as $request)
                    <p>Requested: {{ $request->product_name }}</p>
                @endforeach
            @endif

            @if (!empty($results))
                <h4 class="mt-3">SQL Injection Results:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->id }}</td>
                                <td>{{ $result->name }}</td>
                                <td>{{ $result->email }}</td>
                                <td>{{ $result->credit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif

        @if ($products)
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->photo)
                                    <img src="{{ asset('images/' . $product->photo) }}" alt="{{ $product->name }}" width="50">
                                @else
                                    No Photo
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->hasPermissionTo('edit_products'))
                                    <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @endif
                                @if (auth()->user()->hasPermissionTo('delete_products'))
                                    <form action="{{ route('products_delete', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endif
                                @if (auth()->user()->hasRole('Customer'))
                                    <form action="{{ route('products_purchase', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Buy</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-3">No products found.</p>
        @endif

        <a href="{{ route('profile') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>