<!-- resources/views/products/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->id ? 'Edit Product' : 'Add Product' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @include('layouts.menu')

        <h1>{{ $product->id ? 'Edit Product' : 'Add Product' }}</h1>

        <p>Editing as: <strong>{{ $user->name }}</strong></p>

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

        <form method="POST" action="{{ route('products_save') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Product Code</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $product->code) }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $product->model) }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Product Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                @if ($product->photo)
                    <img src="{{ asset('images/' . $product->photo) }}" alt="Product Photo" width="100" class="mt-2">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="{{ route('products_list') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>