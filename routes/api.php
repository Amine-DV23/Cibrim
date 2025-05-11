<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\FournisseursController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Order;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
return response()->json(['message' => 'Invalid login credentials'], 401);
    }

return response()->json(['message' => 'Login successful', 'user' => $user]);
});

Route::apiResource('products', ProductController::class);
Route::post('/products', [ProductController::class, 'store']);

Route::middleware('auth:sanctum')->get('/products', [ProductsController::class, 'index']);
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::put('/products/{id}', [ProductsController::class, 'update']);
Route::delete('/products/{id}', [ProductsController::class, 'destroy']);


Route::get('/clients', [ClientsController::class, 'index']);
Route::get('/clients/{id}', [ClientsController::class, 'show']);
Route::post('/clients', [ClientsController::class, 'store2']);
Route::put('/clients/{id}', [ClientsController::class, 'update']);
Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);


Route::get('/fournisseurs', [FournisseursController::class, 'index']);
Route::get('/fournisseurs/{id}', [FournisseursController::class, 'show']);
Route::post('/fournisseurs', [FournisseursController::class, 'store2']);
Route::put('/fournisseurs/{id}', [FournisseursController::class, 'update']);
Route::delete('/fournisseurs/{id}', [FournisseursController::class, 'destroy']);

Route::apiResource('orders', OrderController::class);
Route::post('/orders', [OrderController::class, 'store']);

Route::get('products', function () {
    return response()->json(Product::all());
});

Route::get('clients', function () {
    return response()->json(Client::all());
});

Route::get('fournisseurs', function () {
    return response()->json(Fournisseur::all());
});

Route::get('users', function () {
    return response()->json(User::all());
});

Route::get('orders', function () {
    return response()->json(Order::all());
});


Route::get('/users', [UserController::class, 'index']);
