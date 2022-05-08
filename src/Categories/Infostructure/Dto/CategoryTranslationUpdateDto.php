<?php
namespace App\Categories\Infostructure\Dto;

use App\Categories\Infostructure\Constraint\CategoryTitle;
use App\Categories\Infostructure\Constraint\LanguageLocale;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryTranslationUpdateDto
{
    /**
     * @var string 
     */
    #[LanguageLocale()]
    #[Groups(['category:write'])]
    public $locale;

    /**
     * @var string
     */
    #[CategoryTitle()]
    #[Groups(['category:write'])]
    public $title;
}