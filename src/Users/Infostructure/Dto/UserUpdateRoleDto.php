<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\UpdateRole\Command;
use App\Users\Infostructure\Constraint\UserRole;
use Symfony\Component\Serializer\Annotation\Groups;

class UserUpdateRoleDto implements InputDtoInterface
{
    /**
     * A user entity id
     */
    public $id;

    /**
     * @var string
     */
    #[UserRole()]
    #[Groups(['user:write'])]
    public $role;
    

    public function createCommand(): Command
    {
        return new Command($this->id, $this->role);
    }    
}