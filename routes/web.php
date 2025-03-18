<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// المسارات المتاحة للجميع (المسجلين وغير المسجلين)
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/pharmacies-by-location/{location}', 'getPharmaciesByLocation')->name('pharmacies.by.location');
    Route::get('/pharmacy/show/{id}', 'show')->name('pharmacy.show');
    Route::get('/check-auth', 'checkAuth')->name('check.auth');
    Route::get('/ask','ask')->name('ask');
    Route::get('/search','search')->name('search');
    Route::get('/contact','connectus')->name('contact');
});

// المسارات التي تتطلب أن يكون المستخدم غير مسجل (guest)
Route::middleware('guest:web')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});

// المسارات التي تتطلب تسجيل الدخول
Route::controller(CartController::class)->name('cart.')->prefix('cart')->middleware('auth')->group(function(){
    Route::post('/add/{id}', 'add')->name('add');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/', 'sala')->name('sala');
    Route::get('/count', 'getCartCount')->name('count');
    Route::post('/update/{id}', 'updateQuantity')->name('update'); // مسار جديد
    Route::delete('/remove/{id}', 'remove')->name('remove');
});

require __DIR__ . '/auth.php';


