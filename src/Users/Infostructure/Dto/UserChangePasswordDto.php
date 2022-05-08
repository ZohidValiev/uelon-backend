<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\ChangePassword\Command;
use App\Users\Infostructure\Constraint\CurrentPassword;
use App\Users\Infostructure\Constraint\UserPassword;
use App\Users\Infostructure\Constraint\UserPasswordRepeat;

class UserChangePasswordDto implements InputDtoInterface
{
    /**
     * @var string
     */
    #[CurrentPassword()]
    public $currentPassword;

    /**
     * @var string
     */
    #[UserPassword()]
    public $password;

    /**
     * @var string
     */
    #[UserPasswordRepeat()]
    public $passwordRepeat;

    public function createCommand(): Command
    {
        return new Command($this->currentPassword, $this->password);
    }
}