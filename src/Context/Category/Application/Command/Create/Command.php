<?php
namespace App\Context\Category\Application\Command\Create;


class Command 
{
    public ?int $parentId;

    public string $icon;

    public bool $isActive;

    /**
     * @var Translation[]
     */
    public array $translations;
}