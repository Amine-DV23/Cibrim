<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\FournisseursController;
use App\Http\Controllers\OrdersController;

// مسارات إعادة تعيين كلمة المرور
Route::middleware('guest')->group(function () {
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);
});


// تسجيل الخروج
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// التوثيق الافتراضي من Laravel
Auth::routes();

// الصفحة الرئيسية
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// مسارات محمية للمستخدمين المسجلين
Route::middleware('auth')->group(function () {

    // المنتجات
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

    // العملاء
    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
    Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store');
    Route::put('/clients/{id}', [ClientsController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy');
    Route::get('/clients/{id}', [ClientsController::class, 'show'])->name('clients.show');


    // المزود
    Route::get('/fournisseurs', [FournisseursController::class, 'index'])->name('fournisseurs');
    Route::post('/fournisseurs', [FournisseursController::class, 'store'])->name('fournisseurs.store');
    Route::put('/fournisseurs/{id}', [FournisseursController::class, 'update'])->name('fournisseurs.update');
    Route::delete('/fournisseurs/{id}', [FournisseursController::class, 'destroy'])->name('fournisseurs.destroy');
    Route::get('/fournisseurs/{id}', [FournisseursController::class, 'show'])->name('fournisseurs.show');

    // الطلبات
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::put('/orders/update/{id}', [OrdersController::class, 'update']);
    Route::post('/orders/update/{id}', [OrdersController::class, 'update']);
    Route::delete('/orders/delete/{id}', [OrdersController::class, 'destroy']);

    // بيانات إضافية
    Route::get('/get-clients', [OrdersController::class, 'getClients']);
    Route::get('/get-products', [OrdersController::class, 'getProducts']);
});
