<?php
namespace App\Context\Category\Infostructure\Dto;

use App\Context\Category\Infostructure\Constraint\CategoryIsActive;
use App\Context\Category\Infostructure\Constraint\CategoryTitle;
use Symfony\Component\Validator\Constraints\Valid;

class CategoryUpdateDto
{
    public $icon;

    #[CategoryIsActive()]
    public $isActive;

    /**
     * @var CategoryTranslationUpdateDto[]
     */
    #[Valid()]
    public array $translations = [];
}