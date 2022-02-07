<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\Email;
use App\Context\Common\Infostructure\Constraint\UserPassword;
use App\Context\Common\Infostructure\Constraint\UserPasswordRepeat;


class SignupDto
{
    #[Email()]
    public string $email;

    #[UserPassword()]
    public string $password;

    #[UserPasswordRepeat()]
    public string $passwordRepeat;
}