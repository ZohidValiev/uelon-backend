<?php
namespace App\Shared\Domain\Util;


class Random
{
    public static function generateString(int $length = 13): string
    {
        return \md5(\random_bytes($length));
    }
}