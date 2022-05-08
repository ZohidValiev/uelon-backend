<?php
namespace App\Categories\Infostructure\Dto;

use App\Categories\Infostructure\Constraint\CategoryTitle;
use App\Categories\Infostructure\Constraint\LanguageLocale;

class CategoryTranslationCreateDto
{
    /**
     * @var string
     */
    #[LanguageLocale()]
    public $locale;

    /**
     * @var string
     */
    #[CategoryTitle()]
    public $title;
}