<?php

if (!function_exists('getRouteName')) {
    function getRouteName($base)
    {
        $prefix = auth()->guard('admin')->check() ? 'admin.' : 'user.';
        return $prefix . $base;
    }
}
