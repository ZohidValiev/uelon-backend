<?php
namespace App\Categories\Domain\Entity\Service\CategoryUpdateService;

use App\Categories\Domain\Entity\Category;

class ServiceParam 
{
    public function __construct(
        public readonly Category $category,
        public readonly string $icon,
        public readonly bool $isActive,
        public readonly array $translations,
    )
    {}
}