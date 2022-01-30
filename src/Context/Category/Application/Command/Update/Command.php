<?php
namespace App\Context\Category\Application\Command\Update;


class Command 
{
    public function __construct(
        // Category id
        private int $id,
        // Category icon
        private string $icon,
        // category isActive
        private bool $isActive,
        private array $translations,
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }
}