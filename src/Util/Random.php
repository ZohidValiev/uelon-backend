<?php
namespace App\Util;


class Random
{
    public static function generateRandomString(int $length = 13): string
    {
        return \md5(\random_bytes($length));
    }
}