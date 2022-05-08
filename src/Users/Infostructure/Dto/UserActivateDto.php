<?php
namespace App\Users\Infostructure\Dto;

use App\Shared\Application\Dto\InputDtoInterface;
use App\Users\Application\Command\User\Activate\Command;

final class UserActivateDto implements InputDtoInterface
{
    /**
     * @var string
     */
    public $token;

    
    public function createCommand(): Command
    {
        return new Command($this->token);
    }    
}