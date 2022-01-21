<?php
namespace App\Context\Category\Application\Query\Translation\Get;


class Query 
{
    public function __construct(private int $categoryId, private string $locale)
    {
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}