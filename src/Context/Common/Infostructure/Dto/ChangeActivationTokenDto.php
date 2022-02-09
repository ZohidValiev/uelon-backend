<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\Email;

final class ChangeActivationTokenDto
{
    #[Email()]
    public $email;
}