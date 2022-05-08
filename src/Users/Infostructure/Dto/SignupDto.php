<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\Signup\Command;
use App\Users\Infostructure\Constraint\Email;
use App\Users\Infostructure\Constraint\UserPassword;
use App\Users\Infostructure\Constraint\UserPasswordRepeat;

class SignupDto implements InputDtoInterface
{
    /**
     * @var string
     */
    #[Email()]
    public string $email;

    /**
     * @var string
     */
    #[UserPassword()]
    public string $password;

    /**
     * @var string
     */
    #[UserPasswordRepeat()]
    public string $passwordRepeat;
    

    public function createCommand(): Command
    {
        return new Command($this->email, $this->password);
    }    
}