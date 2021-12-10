<?php

namespace App\Includes;

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

        return $links;
    }
}
