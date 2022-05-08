<?php
namespace App\Categories\Application\Command\Update;


class Translation
{
    public function __construct(
        // Translation locale
        public readonly string $locale,
        // Translation title
        public readonly string $title,
    )
    {}
}