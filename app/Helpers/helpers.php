<?php

if (!function_exists('get_product_code')) {
    function get_random_code($length = 9): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('get_decimal')) {
    function get_decimal($value, $decimals)
    {
        return number_format($value, $decimals, '.', '') * 1;
    }
}

if (!function_exists('get_by_percent')) {
    function get_by_percent($number, $percent)
    {
        return $number - ($number * $percent) / 100;
    }
}

if (!function_exists('get_price_from_discounted')) {
    function get_price_from_discounted($number, $percent)
    {
        return $number * 100 / (100 - $percent);
    }
}
