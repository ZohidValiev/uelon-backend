<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\UpdateNickname\Command;
use App\Users\Infostructure\Constraint\UserNickname;
use Symfony\Component\Serializer\Annotation\Groups;

class UserUpdateNicknameDto implements InputDtoInterface
{
    /**
     * A user entity id 
     */
    public $id;

    /**
     * @var string
     */
    #[UserNickname()]
    #[Groups(['user:write'])]
    public $nickname;
       

    public function createCommand(): Command
    {
        return new Command($this->id, $this->nickname);
    }        
}