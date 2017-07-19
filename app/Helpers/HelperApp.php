<?php namespace Ecep\Helpers;

class HelperApp
{
    public static function baseUrl($url = '')
    {
        if ($url != '') {
            $firstLetter = substr($url, 0, 1);
            $url = ($firstLetter == '/') ? substr($url, 1) : $url;
            $finalUrl = env('BASE_URL') . $url;

            return $finalUrl;
        } else {
            return env('BASE_URL');
        }
    }

    public static function baseUrlReal($url = '')
    {
        if ($url != '') {
            $firstLetter = substr($url, 0, 1);
            $url = ($firstLetter == '/') ? substr($url, 1) : $url;
            $finalUrl = env('REAL_URL') . $url;

            return $finalUrl;
        } else {
            return env('REAL_URL');
        }
    }
}