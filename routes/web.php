<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return view('index');
});
// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admins.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admins.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admins.logout');

    // Route::middleware('admin')->group(function () {
        Route::get('index', function () {
            return view('admin.index');
        })->name('admins.index');

        // User
        Route::resource('users', UserController::class);
        // Route::get('users', [UserController::class, 'index'])->name('admin.users');
        // Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');

        // Product Category
        Route::resource('categories', ProductCategoryController::class);
        // Route::get('categories', [ProductCategoryController::class, 'index'])->name('admin.categories');
        // Route::get('categories/create', [ProductCategoryController::class, 'create'])->name('admin.categories.create');

        // Product
        Route::resource('products', ProductController::class);
        // Route::get('products', [ProductController::class, 'index'])->name('admin.products');
        // Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
        
    // });
});

// User routes
Route::prefix('user')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('users.login');
    Route::post('login', [UserAuthController::class, 'login'])->name('users.login.post');
    Route::post('logout', [UserAuthController::class, 'logout'])->name('users.logout');

    // Route::middleware('auth')->group(function () {
        Route::get('dashboard', function () {
            return view('user.index');
        })->name('users.dashboard');
    // });
});