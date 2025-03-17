<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\OrderController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CategoryController;
use App\Http\Controllers\Company\MedicineController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\PharmacyController;
use App\Http\Controllers\Company\Auth\RegisteredUserController;
use App\Http\Controllers\Company\Auth\AuthenticatedSessionController;

Route::prefix('company')->name('company.')->group(function () {
    // المسارات العامة (غير مصادقة)
    Route::middleware('guest:company')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // المسارات المصادقة (لوحة التحكم والإدارة)
    Route::middleware('auth:company')->group(function () {

        // لوحة التحكم
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        //ادارة الادوية
        Route::controller(MedicineController::class)->prefix('medicines')->name('medicines.')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('{medicine}/edit', 'edit')->name('edit');
            Route::delete('{medicine}', 'destroy')->name('destroy');
            Route::put('{id}',  'update')->name('update');
        });


        //ادارة الطلبات
        Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::patch('/{id}/update-status', 'updateStatus')->name('updateStatus');
        });

        Route::controller(PharmacyController::class)->prefix('pharmacies')->name('pharmacies.')->group(function () {
            Route::get('index', 'index')->name('index'); // عرض قائمة الصيدليات

            Route::get('{pharmacy}/show', 'show')->name('show');
            Route::delete('{id}', 'destroy')->name('destroy'); // حذف صيدلية
        });

        //ادارة الادوية
        Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::put('{id}',  'update')->name('update');
        });

        // تسجيل الخروج
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/profile', [CompanyController::class, 'profile'])->name('profile');
        Route::put('/profile', [CompanyController::class, 'updateProfile'])->name('profile.update');
    });
});
