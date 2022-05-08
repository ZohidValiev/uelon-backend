<?php
namespace App\Categories\Domain\Entity\Service\CategoryCreateService;


class ServiceParam
{
    public function __construct(
        public readonly string $icon, 
        public readonly bool $isActive, 
        public readonly array $translations, 
        public readonly ?int $parentId,
    )
    {}
}