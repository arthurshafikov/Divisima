<?php

namespace App\Includes;

use Exception;
use Illuminate\Support\Facades\Cookie;

class CookieHelper
{
    protected const DEFAULT_MINUTES = 60 * 24;
    protected const DEFAULT_VALUE = null;

    public static function getJSONCookie(string $cookieName)
    {
        $cookie = request()->cookie($cookieName);
        if ($cookie) {
            try {
                return json_decode($cookie, true);
            } catch (Exception $e) {
                Cookie::queue($cookieName, json_encode(self::DEFAULT_VALUE), 0);
            }
        }

        return null;
    }

    private static function setJSONCookie(string $cookieName, $value, int $minutes): void
    {
        Cookie::queue($cookieName, json_encode($value), $minutes);
    }

    public static function updateArrayCookie(
        string $cookieName,
        $value,
        ?int $minutes = null,
        bool $unique = true
    ): void {
        $minutes = $minutes ?? self::DEFAULT_MINUTES;
        $cookie = self::getJSONCookie($cookieName);
        if (!is_array($cookie)) {
            $cookie = [];
        }
        if ($unique === true && in_array($value, $cookie)) {
            return;
        }
        $cookie[] = $value;
        self::setJSONCookie($cookieName, $cookie, $minutes, true);
    }

    public static function removeFromArrayCookie(string $cookieName, $value, ?int $minutes = null): void
    {
        $minutes = $minutes ?? self::DEFAULT_MINUTES;
        $cookie = self::getJSONCookie($cookieName);
        if (!is_array($cookie)) {
            $cookie = [];
        }
        if (in_array($value, $cookie)) {
            $cookie = array_diff($cookie, array($value));
        }
        self::setJSONCookie($cookieName, $cookie, $minutes, true);
    }
}
