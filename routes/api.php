<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\Customer\CustomerAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Public APIs không cần auth
Route::prefix('v1')->group(function () {
    // Auth APIs
    Route::post('login', [CustomerAuthController::class, 'login']);

    // Location APIs
    Route::prefix('locations')->group(function () {
        Route::get('provinces', [LocationController::class, 'getProvinces']);
        Route::get('districts/{province_id}', [LocationController::class, 'getDistricts']);
        Route::get('communes/{district_id}', [LocationController::class, 'getCommunes']);
        Route::get('search', [LocationController::class, 'search']);
    });

    // Products
    Route::prefix('products')->group(function () {
        // API lấy danh sách sản phẩm, ví dụ: GET /api/products?page=2
        Route::get('/', [ProductController::class, 'index']);

        // API lấy chi tiết sản phẩm theo id, ví dụ: GET /api/products/5
        Route::get('/{product}', [ProductController::class, 'show']);
    });
});

// Protected APIs - yêu cầu auth với passport
Route::middleware('auth:customer')->prefix('v1')->group(function () {
    // Customer APIs
    Route::prefix('customer')->group(function () {
        Route::post('logout', [CustomerAuthController::class, 'logout']);
        Route::get('profile', [CustomerController::class, 'profile']);
        // Route::put('profile', [CustomerController::class, 'updateProfile']);
        Route::match(['put', 'patch'], 'profile', [CustomerController::class, 'updateProfile']);
        Route::put('change-password', [CustomerController::class, 'changePassword']);
        // Route::get('profile', [CustomerAuthController::class, 'profile']);
        // Route::put('profile', [CustomerAuthController::class, 'updateProfile']);
        // Route::put('change-password', [CustomerAuthController::class, 'changePassword']);

        // Route mua hàng: POST /api/v1/orders/purchase
        Route::post('orders/purchase', [OrderController::class, 'purchase']);
    });
});
/**
 * API Routes cần xác thực với sanctum
 */
Route::middleware('auth:sanctum')->group(function () {
    // Customer API routes
    Route::prefix('test')->group(function () {
        // Routes cho customer
    });
});
