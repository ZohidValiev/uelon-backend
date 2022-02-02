<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\Email;
use App\Context\Common\Infostructure\Constraint\UserPassword;

final class SigninInputDto 
{
    #[Email()]
    public $username;

    #[UserPassword()]
    public $password;
}