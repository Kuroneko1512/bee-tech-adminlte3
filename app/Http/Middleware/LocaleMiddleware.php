<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request. 
     * * Xử lý yêu cầu và đặt ngôn ngữ dựa trên session.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy locale từ session, nếu không có thì lấy giá trị mặc định từ config/app.php
        $locale = Session::get('locale', config('app.locale'));
        // Đặt locale cho toàn bộ ứng dụng
        // App::setLocale($locale);
        // Kiểm tra locale có trong danh sách ngôn ngữ được cấu hình
        $availableLanguages = array_keys(config('languages'));

        if (in_array($locale, $availableLanguages)) {
            App::setLocale($locale);
        }


        return $next($request);
    }
}
