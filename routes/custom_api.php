<?php

use Illuminate\Support\Facades\Route;

Route::get("other-api", function () {
    return response()->json([
        'success' => true,
        'message' => 'Đây là API khác',
        'data' => []
    ]);
});
