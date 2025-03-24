
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacy\CustomerController;
use App\Http\Controllers\Pharmacy\OrderController;
use App\Http\Controllers\Pharmacy\MedicineController;
use App\Http\Controllers\Pharmacy\PharmacyController;
use App\Http\Controllers\Pharmacy\DashboardController;
use App\Http\Controllers\Pharmacy\Auth\RegisteredUserController;
use App\Http\Controllers\Pharmacy\Auth\AuthenticatedSessionController;

Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
    // المسارات العامة (غير مصادقة)
    // Route::middleware('guest:pharmacy')->group(function () {
    //     Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    //     Route::post('register', [RegisteredUserController::class, 'store']);

    //     Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    //     Route::post('login', [AuthenticatedSessionController::class, 'store']);
    // });

    // المسارات المصادقة (لوحة التحكم والإدارة)
    Route::middleware('auth:pharmacy')->group(function () {
        // لوحة التحكم
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // إدارة الأدوية
        Route::controller(MedicineController::class)->prefix('medicine')->name('medicine.')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('order', 'order')->name('order'); // قد تحتاج إلى تعديل الدالة
        });

        // إدارة الطلبات
        Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('sent', 'sentOrders')->name('sent');
            Route::get('customer', 'customerOrder')->name('customer');
            Route::get('/{id}', 'show')->name('show');

            Route::post('/{id}/update-status', 'updateStatus')->name('update-status');
        });

        // إدارة المخزون
        Route::controller(PharmacyController::class)->prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/{pharmacyId}', 'showInventory')->name('show');

        });

        // تسجيل الخروج
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/profile', [PharmacyController::class, 'profile'])->name('profile');
        Route::put('/profile', [PharmacyController::class, 'updateProfile'])->name('profile.update');

    });


    Route::controller(CustomerController::class)->prefix('customers')->name('customers.')->group(function () {
        Route::get('add', 'create')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('index', 'index')->name('index');
    });
});
