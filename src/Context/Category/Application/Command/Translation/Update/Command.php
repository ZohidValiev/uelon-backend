<?php
namespace App\Context\Category\Application\Command\Translation\Update;


class Command
{
    public int $categoryId;

    public string $locale;

    public string $title;
}