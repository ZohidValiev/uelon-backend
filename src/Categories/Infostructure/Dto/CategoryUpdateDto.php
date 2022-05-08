<?php
namespace App\Categories\Infostructure\Dto;

use App\Categories\Application\Command\Update\Command;
use App\Categories\Application\Command\Update\Translation;
use App\Categories\Infostructure\Constraint\CategoryIsActive;
use App\Shared\Application\Dto\InputDtoInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

class CategoryUpdateDto implements InputDtoInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    #[Groups(['category:write'])]
    public $icon;

    /**
     * @var bool
     */
    #[CategoryIsActive()]
    #[Groups(['category:write'])]
    public $isActive;

    /**
     * @var CategoryTranslationUpdateDto[]
     */
    #[Valid()]
    #[Groups(['category:write'])]
    public array $translations = [];

    public function createCommand(): Command
    {
        return new Command(
            $this->id,
            $this->icon,
            $this->isActive,
            array_map(function(CategoryTranslationUpdateDto $translation) {
                return new Translation($translation->locale, $translation->title);
            }, $this->translations),
        );
    }
}