<?php
namespace App\Context\Category\Infostructure\Dto;

use App\Context\Category\Infostructure\Constraint\CategoryTitle;
use App\Context\Category\Infostructure\Constraint\LanguageLocale;

class CategoryTranslationCreateDto
{
    #[LanguageLocale()]
    public $locale;

    #[CategoryTitle()]
    public $title;
}