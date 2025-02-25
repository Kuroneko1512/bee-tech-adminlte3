<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\LocationExportController;

/*
* Đây là router test dành cho web
*/

Route::get("/web2", function () {
    return 'Đây là đường link web 2';
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

// Route::get('exports', [ProductsExport::class, 'exports'])->name('locations.exports');

// // Route download file export (ví dụ: /download-export?file=exports/products.xlsx)
// Route::get('download-export', [ProductsExport::class, 'downloadExport'])->name('locations.export.download');


// Location Export
Route::get('location/list', [LocationController::class, 'list'])->name('location.list');
Route::get('location/export', [LocationExportController::class, 'export'])->name('location.export');
Route::get('location/export/download', [LocationExportController::class, 'download'])->name('location.export.download');
