<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

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
/**
 * API Routes cho địa chỉ - không cần auth
 */
Route::prefix('locations')->group(function() {
    Route::get('provinces', [LocationController::class, 'getProvinces']);
    Route::get('districts/{province_id}', [LocationController::class, 'getDistricts']);
    Route::get('communes/{district_id}', [LocationController::class, 'getCommunes']);
    Route::get('search', [LocationController::class, 'search']); // API tìm kiếm địa chỉ
});

/**
 * API Routes cần xác thực
 */
Route::middleware('auth:sanctum')->group(function() {
    // Customer API routes
    Route::prefix('customer')->group(function() {
        // Routes cho customer
    });
});
