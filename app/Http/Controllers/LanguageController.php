<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Thay đổi ngôn ngữ của ứng dụng
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($lang)
    {
        // Lấy danh sách ngôn ngữ được hỗ trợ từ config
        $languages = Config::get('languages');

        // Kiểm tra ngôn ngữ có tồn tại trong config
        if (array_key_exists($lang, $languages)) {
            // Lưu locale vào session
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
}
