<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\UpdateStatus\Command;
use App\Users\Infostructure\Constraint\UserStatus;
use Symfony\Component\Serializer\Annotation\Groups;

class UserUpdateStatusDto implements InputDtoInterface
{
    /**
     * A user entity id
     */
    public $id;

    /**
     * @var int
     */
    #[UserStatus()]
    #[Groups(['user:write'])]
    public $status;
    

    public function createCommand(): Command
    {
        return new Command($this->id, $this->status);
    }    
}