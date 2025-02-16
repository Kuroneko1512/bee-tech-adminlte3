<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class LanguageComposer
{
    /**
     * Bind data to the view.
     * Inject language configuration vào view được chỉ định
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Lấy cấu hình ngôn ngữ từ config/languages.php
        // và gán vào biến $languages trong view
        $view->with('languages', Config::get('languages'));
    }
}
