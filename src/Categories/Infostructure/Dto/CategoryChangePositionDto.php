<?php
namespace App\Categories\Infostructure\Dto;

use App\Categories\Application\Command\ChangePosition\Command;
use App\Categories\Infostructure\Constraint\CategoryPosition;
use App\Shared\Application\Dto\InputDtoInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryChangePositionDto implements InputDtoInterface
{
    /**
     * The category entity id
     * @var int
     */
    public $id;

    /**
     * The category entity new position
     * @var int
     */
    #[CategoryPosition()]
    #[Groups(['category:write'])]
    public $position;


    public function createCommand(): Command
    {
        return new Command($this->id, $this->position);
    }    
}