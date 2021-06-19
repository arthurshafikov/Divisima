<?php

namespace App\Includes;

use Illuminate\Support\Facades\Route;

class BreadCrumbs
{
    public static function getBreadCrumbs(): array
    {
        @$url = $_SERVER["REQUEST_URI"];
        $arr = explode('/', ltrim($url, '/'));

        $links = [
            '/' => 'Home',
        ];
        foreach ($arr as $elem) {
            $elem = explode('?', $elem)[0];
            $link = '/' . $elem;

            if ($elem === 'product') {
                $link = route('shop', [], false);
            }
            $links[$link] = ucfirst($elem);
        };

        $current = Route::currentRouteName();
        if (preg_match('/^.*?\.edit$/', $current)) {
            foreach ($links as $link => $text) {
                if (preg_match('#^/dashboard/.*?/\d+$#', $link)) {
                    unset($links[$link]);
                }
            }
        }
        return $links;
    }
}
