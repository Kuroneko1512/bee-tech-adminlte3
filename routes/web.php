<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('language/{lang}', [LanguageController::class, 'changeLanguage'])->name('language.change');
Route::get('/', function () {
    return view('index');
});
// Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Route login
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admins.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admins.login.post');


    //Route auth:guard admin
    Route::middleware('admin')->group(function () {

        Route::get('index', function () {
            return view('admin.index');
        })->name('admins.index');

        // User
        Route::resource('users', UserController::class);

        // Product Category
        Route::resource('categories', ProductCategoryController::class);

        // Product
        Route::resource('products', ProductController::class);
        Route::get('products/download/{type}', [ProductController::class, 'download'])->name('products.download');

        //Logout
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admins.logout');

        // Thêm routes cho location
        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('locations/import', [LocationController::class, 'import'])->name('locations.import');
        Route::get('locations/import/progress', [LocationController::class, 'importProgress'])->name('locations.import.progress');

        // Order management routes
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/download', [OrderController::class, 'download'])->name('orders.download');
    });
});

// User routes
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('users.login');
    Route::post('login', [UserAuthController::class, 'login'])->name('users.login.post');

    // Password Reset Routes
    Route::get('forgot-password', [UserAuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('forgot-password', [UserAuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password', [UserAuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [UserAuthController::class, 'reset'])->name('password.update');
    Route::middleware('auth')->group(function () {

        Route::get('dashboard', function () {
            return view('user.index');
        })->name('users.dashboard');

        // Product Category
        Route::resource('categories', ProductCategoryController::class);

        // Product
        Route::resource('products', ProductController::class);
        Route::get('products/download/{type}', [ProductController::class, 'download'])->name('products.download');

        //Logout
        Route::post('logout', [UserAuthController::class, 'logout'])->name('users.logout');

        // Order management routes
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/download', [OrderController::class, 'download'])->name('orders.download');
    });
});


Route::get('/test-mail', function () {
    try {
        Debugbar::info('Testing mail connection...');

        Mail::raw('Test email from ' . config('app.name'), function ($message) {
            // $message->to('michaeltran041098@gmail.com')
            $message->to('thomt1512@gmail.com')
                ->subject('Test Mail Configuration');
        });

        Debugbar::success('Email sent successfully');
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        Debugbar::error('Mail Error: ' . $e->getMessage());
        Debugbar::error($e->getTraceAsString());

        return view('errors.mail-test', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});
