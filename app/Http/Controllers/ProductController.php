<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function productsPage()
    {
        $products = Product::all();
        $products = Product::where('user_id', auth()->user()->id)->get();

        return view('products.products', compact('products'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'user_id' => 'required|exists:users,id',
        ]);


        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $product = Product::create($validated);

        return response()->json($product, 201);
    }



    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                @unlink(public_path('images/' . $product->image));
            }
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            @unlink(public_path('images/' . $product->image));
        }
        $product->delete();
        return response()->json(null, 204);
    }
}
