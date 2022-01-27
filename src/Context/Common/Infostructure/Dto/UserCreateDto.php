<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\Email;
use App\Context\Common\Infostructure\Constraint\UserNickname;
use App\Context\Common\Infostructure\Constraint\UserPassword;
use App\Context\Common\Infostructure\Constraint\UserRole;
use App\Context\Common\Infostructure\Constraint\UserStatus;
use App\Context\Common\Infostructure\Constraint\Verification;

class UserCreateDto
{
    /**
     * User email
     */
    #[Email()]
    public $email;

    /**
     * User nickname
     */
    #[UserNickname()]
    public $nickname;

    /**
     * User role
     */
    #[UserRole()]
    public $role;

    /**
     * User password
     */
    #[UserPassword()]
    public $password;

    /**
     * User status
     */
    #[UserStatus()]
    public $status;

    #[Verification()]
    public $useVerification;
}