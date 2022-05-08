<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\Create\Command;
use App\Users\Infostructure\Constraint\Email;
use App\Users\Infostructure\Constraint\SendNotification;
use App\Users\Infostructure\Constraint\UserNickname;
use App\Users\Infostructure\Constraint\UserPassword;
use App\Users\Infostructure\Constraint\UserRole;
use App\Users\Infostructure\Constraint\UserStatus;

class UserCreateDto implements InputDtoInterface
{
    /**
     * User email
     * @var string
     */
    #[Email()]
    public $email;

    /**
     * User nickname
     * @var string
     */
    #[UserNickname()]
    public $nickname;

    /**
     * User role
     * @var string
     */
    #[UserRole()]
    public $role;

    /**
     * User password
     * @var string
     */
    #[UserPassword()]
    public $password;

    /**
     * User status
     * @var int
     */
    #[UserStatus()]
    public $status;

    /**
     * @var bool
     */
    #[SendNotification()]
    public $sendNotification;

    public function createCommand(): Command
    {
        return new Command(
            email: $this->email,
            nickname: $this->nickname,
            password: $this->password,
            role: $this->role,
            status: $this->status,
            sendNotification: $this->sendNotification,
        );
    }
}