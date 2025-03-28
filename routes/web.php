<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// الصفحة الرئيسية (تتطلب تسجيل الدخول)
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

// عرض صفحة التسجيل للمستخدمين غير المسجلين
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');

// عرض صفحة تسجيل الدخول للمستخدمين غير المسجلين
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');

// مسارات تسجيل الدخول وتسجيل الخروج
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\HomeController::class, 'index2'])->name('products');
Route::get('/Clients', [App\Http\Controllers\HomeController::class, 'index3'])->name('Clients');
Route::get('/order', [App\Http\Controllers\HomeController::class, 'index4'])->name('order');
