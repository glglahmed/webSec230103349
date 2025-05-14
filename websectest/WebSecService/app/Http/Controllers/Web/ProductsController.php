<?php

// namespace App\Http\Controllers\Web;

// use App\Http\Controllers\Controller;
// use App\Models\Product;
// use App\Models\Purchase;
// use Illuminate\Http\Request;

// class ProductsController extends Controller
// {
//     // public function list(Request $request)
//     // {
//     //     $products = Product::query();

//     //     if ($request->filled('keywords')) {
//     //         $products->where('name', 'like', '%' . $request->keywords . '%')
//     //                  ->orWhere('description', 'like', '%' . $request->keywords . '%');
//     //     }

//     //     if ($request->filled('min_price')) {
//     //         $products->where('price', '>=', $request->min_price);
//     //     }

//     //     if ($request->filled('max_price')) {
//     //         $products->where('price', '<=', $request->max_price);
//     //     }

//     //     if ($request->filled('order_by')) {
//     //         $products->orderBy($request->order_by, $request->order_direction ?? 'ASC');
//     //     }

//     //     $products = $products->get();

//     //     return view('products.list', compact('products'));
//     // }
//     public function list(Request $request)
// {
//     $products = Product::query();

//     if ($request->filled('keywords')) {
//         $products->where('name', 'like', '%' . $request->keywords . '%')
//                  ->orWhere('description', 'like', '%' . $request->keywords . '%');
//     }

//     if ($request->filled('min_price')) {
//         $products->where('price', '>=', $request->min_price);
//     }

//     if ($request->filled('max_price')) {
//         $products->where('price', '<=', $request->max_price);
//     }

//     if ($request->filled('order_by')) {
//         $products->orderBy($request->order_by, $request->order_direction ?? 'ASC');
//     }

//     $products = $products->paginate(10); // Add pagination

//     $credit = auth()->check() ? auth()->user()->credit : 0;

//     return view('products.list', compact('products', 'credit'));
// }
//     public function edit($id)
//     {
//         $product = $id == 0 ? new Product() : Product::findOrFail($id);
//         return view('products.edit', compact('product'));
//     }

//     public function save(Request $request)
//     {
//         $this->validate($request, [
//             'name' => ['required', 'string', 'min:3'],
//             'code' => ['required', 'string', 'min:3', 'unique:products,code,' . $request->id],
//             'price' => ['required', 'numeric', 'min:0'],
//             'stock' => ['required', 'integer', 'min:0'],
//         ]);

//         $product = $request->id == 0 ? new Product() : Product::findOrFail($request->id);
//         $product->name = $request->name;
//         $product->code = $request->code;
//         $product->price = $request->price;
//         $product->model = $request->model;
//         $product->description = $request->description;
//         $product->stock = $request->stock;

//         if ($request->hasFile('photo')) {
//             $file = $request->file('photo');
//             $filename = time() . '.' . $file->getClientOriginalExtension();
//             $file->move(public_path('images'), $filename);
//             $product->photo = $filename;
//         }

//         $product->save();

//         return redirect()->route('products_list')->with('success', 'Product saved successfully!');
//     }

//     public function delete($id)
//     {
//         $product = Product::findOrFail($id);
//         $product->delete();

//         return redirect()->route('products_list')->with('success', 'Product deleted successfully!');
//     }

//     public function purchase(Request $request, Product $product)
//     {
//         $user = auth()->user();

//         // Check if the user has the Customer role
//         if (!$user->hasRole('Customer')) {
//             return redirect()->back()->withErrors('Only customers can purchase products.');
//         }

//         // Check if the product is in stock
//         if ($product->stock <= 0) {
//             return redirect()->back()->withErrors('Product is out of stock.');
//         }

//         // Check if the user has enough credit
//         if ($user->credit < $product->price) {
//             return redirect()->back()->withErrors('Insufficient credit to purchase this product.');
//         }

//         // Deduct the price from the user's credit
//         $user->credit -= $product->price;
//         $user->save();

//         // Reduce the product's stock
//         $product->stock -= 1;
//         $product->save();

//         // Record the purchase
//         Purchase::create([
//             'user_id' => $user->id,
//             'product_id' => $product->id,
//             'quantity' => 1,
//             'total_price' => $product->price,
//         ]);

//         return redirect()->back()->with('success', 'Product purchased successfully!');
//     }
// }<?php
namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;

class ProductsController extends Controller
{
    use ValidatesRequests;

    // public function list(Request $request)
    // {
    //     if (!auth()->user()->hasRole('Customer') && !auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Employee')) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $query = Product::select('*');

    //     if ($request->filled('keywords')) {
    //         $query->where('name', 'like', '%' . $request->keywords . '%')
    //               ->orWhere('code', 'like', '%' . $request->keywords . '%');
    //     }

    //     if ($request->filled('min_price')) {
    //         $query->where('price', '>=', $request->min_price);
    //     }

    //     if ($request->filled('max_price')) {
    //         $query->where('price', '<=', $request->max_price);
    //     }

    //     if ($request->filled('order_by') && $request->filled('order_direction')) {
    //         $query->orderBy($request->order_by, $request->order_direction);
    //     }

    //     $products = $query->paginate(10);

    //     $credit = auth()->check() ? auth()->user()->credit : 0;

    //     return view('products.list', compact('products', 'credit'));
    // }
    public function list(Request $request)
    {
        if (!auth()->user()->hasRole('Customer') && !auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Employee')) {
            abort(403, 'Unauthorized action.');
        }
    
        if ($request->isMethod('post') && $request->has('product_name')) {
            if (!auth()->user()->hasRole('Customer')) {
                return redirect()->back()->withErrors('Only customers can request products.');
            }
    
            $product_name = $request->input('product_name');
            if (!$product_name) {
                return redirect()->back()->withErrors('Product name is required.');
            }
    
            DB::insert('INSERT INTO product_requests (user_id, product_name, created_at, updated_at) VALUES (?, ?, NOW(), NOW())', [
                auth()->id(),
                $product_name
            ]);
    
            $query = "SELECT * FROM users WHERE name = '" . $product_name . "'";
            $results = DB::select($query);
    
            $keywords = addslashes($request->input('keywords', ''));
            $min_price = $request->input('min_price') ?: 0;
            $max_price = $request->input('max_price') ?: 999999;
            $order_by = $request->input('order_by', 'id');
            $order_direction = $request->input('order_direction', 'asc');
    
            $query_products = "SELECT * FROM products WHERE price >= $min_price AND price <= $max_price";
            if ($keywords) {
                $query_products .= " AND (name LIKE '%$keywords%' OR code LIKE '%$keywords%')";
            }
            $query_products .= " ORDER BY $order_by $order_direction";
    
            $products = DB::select($query_products);
    
            $credit = auth()->check() ? auth()->user()->credit : 0;
            $requests = DB::table('product_requests')->where('user_id', auth()->id())->get();
    
            return view('products.list', compact('products', 'credit', 'requests', 'results'));
        }
    
        $keywords = addslashes($request->input('keywords', ''));
        $min_price = $request->input('min_price') ?: 0;
        $max_price = $request->input('max_price') ?: 999999;
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'asc');
    
        $query = "SELECT * FROM products WHERE price >= $min_price AND price <= $max_price";
        if ($keywords) {
            $query .= " AND (name LIKE '%$keywords%' OR code LIKE '%$keywords%')";
        }
        $query .= " ORDER BY $order_by $order_direction";
    
        $products = DB::select($query);
    
        $credit = auth()->check() ? auth()->user()->credit : 0;
        $requests = DB::table('product_requests')->where('user_id', auth()->id())->get();
    
        return view('products.list', compact('products', 'credit', 'requests'));
    }


    public function edit($id)
    {
        $product = $id == 0 ? new Product() : Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            if (!auth()->user()->hasPermissionTo('add_products')) {
                abort(401);
            }
            $product = new Product();
        } else {
            if (!auth()->user()->hasPermissionTo('edit_products')) {
                abort(401);
            }
            $product = Product::findOrFail($request->id);
        }

        $rules = [
            'name' => ['required', 'string', 'min:5'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

      
        if ($request->id == 0) {
            $rules['code'] = ['required', 'string', 'min:5', 'unique:products,code'];
        } else {
            if ($request->code !== $product->code) {
                $rules['code'] = ['required', 'string', 'min:5', 'unique:products,code,' . $product->id];
            }
        }

        
        $this->validate($request, $rules);

        $product->name = $request->name;
        $product->code = $request->code;
        $product->price = $request->price;
        $product->model = $request->model;
        $product->description = $request->description;
        $product->stock = $request->stock;

       
        if ($request->hasFile('photo')) {
            if ($product->photo && file_exists(public_path('images/' . $product->photo))) {
                unlink(public_path('images/' . $product->photo));
            }
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $filename);
            $product->photo = $filename;
        }

        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully!');
    }

    public function delete(Request $request, Product $product)
    {
        if (!auth()->user()->hasPermissionTo('delete_products')) {
            abort(401);
        }

  
        if ($product->photo && file_exists(public_path('images/' . $product->photo))) {
            unlink(public_path('images/' . $product->photo));
        }

        $product->delete();

        return redirect()->route('products_list')->with('success', 'Product deleted successfully!');
    }

    public function purchase(Request $request, Product $product)
    {
       
        if (!auth()->user()->hasRole('Customer')) {
            \Log::error('Unauthorized purchase attempt by user ID: ' . auth()->user()->id);
            abort(403, 'Only customers can purchase products.');
        }

        \Log::info('Purchase attempt: User ID ' . auth()->user()->id . ', Product ID ' . $product->id . ', Credit ' . auth()->user()->credit . ', Product Price ' . $product->price);

        if (auth()->user()->credit < $product->price) {
            \Log::error('Insufficient credit: User ID ' . auth()->user()->id . ', Credit ' . auth()->user()->credit . ', Product Price ' . $product->price);
            return redirect()->back()->withErrors('Insufficient credit to purchase this product.');
        }

        if ($product->stock <= 0) {
            \Log::error('Product out of stock: Product ID ' . $product->id);
            return redirect()->back()->withErrors('Product out of stock.');
        }

        
        auth()->user()->credit -= $product->price;
        auth()->user()->save();
        \Log::info('Credit deducted: User ID ' . auth()->user()->id . ', New Credit ' . auth()->user()->credit);

        $product->stock -= 1;
        $product->save();
        \Log::info('Stock updated: Product ID ' . $product->id . ', New Stock ' . $product->stock);

        try {
            Purchase::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
            \Log::info('Purchase recorded: User ID ' . auth()->user()->id . ', Product ID ' . $product->id . ', Quantity 1, Total Price ' . $product->price);
        } catch (\Exception $e) {
            \Log::error('Failed to record purchase: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to record purchase: ' . $e->getMessage());
        }

        return redirect()->route('products_list')->with('success', 'Product purchased successfully.');
    }
}