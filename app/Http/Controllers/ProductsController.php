<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::where('user_id', auth()->user()->id)->get();
        return view('products.products', compact('products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Product added successfully!', 'status' => 'success']);
        }

        return redirect()->route('products')->with('success', 'Product added successfully!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image) {
                unlink(public_path('images/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Product updated successfully!', 'status' => 'success']);
        }

        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);


        if ($product->user_id !== auth()->user()->id) {
            return redirect()->route('products')->with('error', 'You do not have permission to delete this product.');
        }

        if ($product->image) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }

}
