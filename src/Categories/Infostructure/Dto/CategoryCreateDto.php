<?php
namespace App\Categories\Infostructure\Dto;

use App\Categories\Application\Command\Create\Command;
use App\Categories\Application\Command\Create\Translation;
use App\Categories\Infostructure\Constraint\CategoryIsActive;
use App\Categories\Infostructure\Constraint\CategoryParentId;
use App\Shared\Application\Dto\InputDtoInterface;
use Symfony\Component\Validator\Constraints\Valid;

class CategoryCreateDto implements InputDtoInterface
{
    /**
     * The category entity parentId
     * @var int|null
     */
    #[CategoryParentId()]
    public $parentId = null;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var bool
     */
    #[CategoryIsActive()]
    public bool $isActive;

    /**
     * @var CategoryTranslationCreateDto[]
     */
    #[Valid()]
    public array $translations;

    public function createCommand(): Command
    {
        return new Command(
            $this->icon,
            $this->isActive,
            array_map(function(CategoryTranslationCreateDto $translation) {
                return new Translation($translation->locale, $translation->title);
            }, $this->translations),
            $this->parentId,
        );
    }
}