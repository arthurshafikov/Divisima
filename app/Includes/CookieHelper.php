<?php

namespace App\Includes;

class CookieHelper
{
    protected static $defaultMin = 60 * 24;
    protected static $defaultVal = null;

    public static function getCookie(string $cookieName, $json = false)
    {
        $cookie = request()->cookie($cookieName);
        if (!$cookie) {
            return null;
        }
        if ($json !== false) {
            try {
                $json = json_decode($cookie, true);
            } catch (\Exception $e) {
                \Cookie::queue($cookieName, json_encode(self::$defaultVal), 0);
                return null;
            }
            return $json;
        }
        return $cookie;
    }

    public static function setCookie(string $cookieName, $value = null, $minutes = false, $json = false)
    {
        $minutes = $minutes ? self::$defaultMin : $minutes;
        if ($json === true) {
            $value = json_encode($value);
        }
        \Cookie::queue($cookieName, $value, $minutes);
    }

    public static function updateArrayCookie(string $cookieName, $value, $minutes = false, $unique = true)
    {
        $cookie = self::getCookie($cookieName, true);
        if (!is_array($cookie)) {
            $cookie = [];
        }
        if ($unique === true && in_array($value, $cookie)) {
            return false;
        }
        $cookie[] = $value;
        self::setCookie($cookieName, $cookie, $minutes, true);
    }

    public static function removeFromArrayCookie(string $cookieName, $value, $minutes = false)
    {
        $cookie = self::getCookie($cookieName, true);
        if (!is_array($cookie)) {
            $cookie = [];
        }
        if (in_array($value, $cookie)) {
            $cookie = array_diff($cookie, array($value));
        }
        self::setCookie($cookieName, $cookie, $minutes, true);
    }
}
