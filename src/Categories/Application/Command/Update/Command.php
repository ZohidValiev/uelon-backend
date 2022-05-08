<?php
namespace App\Categories\Application\Command\Update;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    /**
     * @param Translation[] $translations
     */
    public function __construct(
        // Category id
        public readonly int $id,
        // Category icon
        public readonly string $icon,
        // Category isActive
        public readonly bool $isActive,
        // Category translations
        public readonly array $translations,
    )
    {}
}