<?php
namespace App\Context\Category\Application\Command\Update;


class Translation
{
    public function __construct(
        // Translation locale
        private string $locale,
        // Translation title
        private string $title,
    )
    {}

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}