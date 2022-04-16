<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\UserPassword;
use App\Context\Common\Infostructure\Constraint\UserPasswordRepeat;

class UserChangePasswordDto
{
    #[UserPassword()]
    public string $currentPassword;

    #[UserPassword()]
    public string $password;

    #[UserPasswordRepeat()]
    public string $passwordRepeat;
}