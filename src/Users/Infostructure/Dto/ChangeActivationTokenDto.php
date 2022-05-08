<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\ChangeActivationToken\Command;
use App\Users\Infostructure\Constraint\Email;

final class ChangeActivationTokenDto implements InputDtoInterface
{
    /**
     * @var string
     */
    #[Email()]
    public $email;

    
    public function createCommand(): Command
    {
        return new Command($this->email);
    }
}