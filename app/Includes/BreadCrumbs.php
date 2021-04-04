<?php 

namespace App\Includes;

class BreadCrumbs 
{

    public static function getBreadCrumbs() : array
    {
        @$url = $_SERVER["REQUEST_URI"];
        $arr = explode('/',ltrim($url,'/'));
        
        $links = [
            '/' => 'Home'
        ];
        $link = '';
        foreach ($arr as $elem) {
            $elem = explode('?',$elem)[0];
            if ($elem === 'product') {
                $link .= route('shop',[],false);
            } else {
                $link .= '/' . $elem;
            }
            $links[$link] = ucfirst($elem);
        };
        // "products.edit"

        $current = \Route::currentRouteName();
        if (preg_match('/^.*?\.edit$/',$current)) {
            foreach ($links as $link => $text) {
                if(preg_match('#^/dashboard/.*?/\d+$#',$link)){
                    unset($links[$link]);
                }
            }
        }
        return $links;
    }
}