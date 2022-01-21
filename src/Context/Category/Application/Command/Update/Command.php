<?php
namespace App\Context\Category\Application\Command\Update;


class Command 
{
    public int $id;

    public string $icon;

    public bool $isActive;

    /**
     * @var Translation[]
     */
    public array $translations = [];
}