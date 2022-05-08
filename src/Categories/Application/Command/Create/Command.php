<?php
namespace App\Categories\Application\Command\Create;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        // Cateory icon
        public readonly string $icon,
        // Cateory isActive
        public readonly bool $isActive,
        // Category translarions
        public readonly array $translations,
        // Cateory parentId
        public readonly ?int $parentId = null,
    )
    {}
}