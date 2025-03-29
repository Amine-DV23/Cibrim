<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\Order;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض الصفحة
    public function index()
    {
        $user = auth()->user();

        $clients = Client::where('user_id', $user->id)->get();
        $products = Product::where('user_id', $user->id)->get();
        $orders = Order::with('client', 'product')
            ->whereHas('client', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        return view('orders', compact('clients', 'products', 'orders'));
    }


    // جلب العملاء بصيغة JSON
    public function getClients()
    {
        $user = auth()->user();
        return response()->json(Client::where('user_id', $user->id)->get());
    }

    public function getProducts()
    {
        $user = auth()->user();
        return response()->json(Product::where('user_id', $user->id)->get());
    }


    // تخزين الطلب
    public function store(Request $request)
    {
        $client_id = $request->client_id;
        $order_date = $request->order_date;

        foreach ($request->orders as $orderItem) {
            Order::create([
                'client_id'   => $client_id,
                'product_id'  => $orderItem['product_id'],
                'quantity'    => $orderItem['quantity'],
                'total_price' => $orderItem['total_price'],
                'order_date'  => $order_date,
            ]);
        }

        return response()->json(['success' => true]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // تحديث بيانات الطلب
        $order->update([
            'client_id'   => $request->client_id,
            'product_id'  => $request->orders[0]['product_id'], // نأخذ أول منتج فقط
            'quantity'    => $request->orders[0]['quantity'],
            'total_price' => $request->orders[0]['total_price'],
            'order_date'  => $request->order_date,
        ]);

        return response()->json(['success' => true]);
    }


public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return response()->json(['success' => true]);
}
}
