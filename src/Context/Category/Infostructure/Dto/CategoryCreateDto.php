<?php
namespace App\Context\Category\Infostructure\Dto;

use App\Context\Category\Infostructure\Constraint\CategoryIsActive;
use App\Context\Category\Infostructure\Constraint\CategoryParentId;
use Symfony\Component\Validator\Constraints\Valid;

class CategoryCreateDto
{
    #[CategoryParentId()]
    public $parentId = null;

    public $icon;

    #[CategoryIsActive()]
    public bool $isActive;

    /**
     * @var CategoryTranslationCreateDto[]
     */
    #[Valid()]
    public array $translations;
}