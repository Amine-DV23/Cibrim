<?php

    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\LoginController;

    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\HomeController;

    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\ProductsController;
    use App\Http\Controllers\ClientsController;
    use App\Http\Controllers\FournisseursController;
    use App\Http\Controllers\OrdersController;



    Auth::routes();


    Route::middleware('auth')->group(function () {


        Route::middleware('guest')->group(function () {
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset']);
    });


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');


    Route::get('/products-page', [ProductController::class, 'productsPage']);


    Route::get('/clients-Page', [ClientsController::class, 'clientsPage']);


    Route::get('/fournisseurs-Page', [FournisseursController::class, 'fournisseursPage']);


    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');


    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
    Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store');
    Route::put('/clients/{id}', [ClientsController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy');
    Route::get('/clients/{id}', [ClientsController::class, 'show'])->name('clients.show');


    Route::get('/fournisseurs', [FournisseursController::class, 'index'])->name('fournisseurs');
    Route::post('/fournisseurs', [FournisseursController::class, 'store'])->name('fournisseurs.store');
    Route::put('/fournisseurs/{id}', [FournisseursController::class, 'update'])->name('fournisseurs.update');
    Route::delete('/fournisseurs/{id}', [FournisseursController::class, 'destroy'])->name('fournisseurs.destroy');
    Route::get('/fournisseurs/{id}', [FournisseursController::class, 'show'])->name('fournisseurs.show');


    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::put('/orders/update/{id}', [OrdersController::class, 'update']);
    Route::post('/orders/update/{id}', [OrdersController::class, 'update']);
    Route::delete('/orders/delete/{id}', [OrdersController::class, 'destroy']);


    Route::get('/get-clients', [OrdersController::class, 'getClients']);
    Route::get('/get-products', [OrdersController::class, 'getProducts']);
});
