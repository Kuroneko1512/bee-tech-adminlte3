<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * Đăng ký các view composers
     */
    public function boot(): void
    {
        // Đăng ký LanguageComposer cho view header-nav
        View::composer(
            'admin.layouts.partials.header-nav',
            \App\Http\View\Composers\LanguageComposer::class
        );
    }
}
