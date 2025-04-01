<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();


        $orders = Order::orderBy('order_group_id', 'asc')->get(); // ترتيب البيانات حسب رقم المجموعة

        $clients = Client::where('user_id', $user->id)->get();
        $products = Product::where('user_id', $user->id)->get();

        return view('orders.orders', compact('clients', 'products', 'orders'));
    }




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


    public function store(Request $request)
    {

        $lastGroupNumber = Order::max('order_group_id');


        $newGroupNumber = $lastGroupNumber ? $lastGroupNumber + 1 : 1;


        foreach ($request->orders as $order) {
            Order::create([
                'order_group_id' => $newGroupNumber, // الرقم الجديد للمجموعة
                'client_id' => $request->client_id,
                'product_id' => $order['product_id'],
                'quantity' => $order['quantity'],
                'total_price' => $order['total_price'],
                'order_date' => $request->order_date,
            ]);
        }

        return response()->json(['success' => true]);
    }


    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

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
