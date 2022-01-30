<?php
namespace App\Context\Category\Application\Command\Create;


class Command 
{
    // public ?int $parentId;

    // public string $icon;

    // public bool $isActive;

    // /**
    //  * @var Translation[]
    //  */
    // public array $translations;

    public function __construct(
        // Cateory parentId
        private ?int $parentId,
        // Cateory icon
        private string $icon,
        // Cateory isActive
        private bool $isActive,
        // Category translarions
        private array $translations,
    )
    {}

    public function getParentId(): ?int
    {
        return $this->parentId;
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