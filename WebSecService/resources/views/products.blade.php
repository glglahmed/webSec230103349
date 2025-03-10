<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Product Catalog</h2>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $product['image'] }}" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">{{ $product['description'] }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ $product['price'] }}</p>
                    <button class="btn btn-primary">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
