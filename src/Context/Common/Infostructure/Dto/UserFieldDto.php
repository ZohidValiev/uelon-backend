<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\UserNickname;
use App\Context\Common\Infostructure\Constraint\UserRole;
use App\Context\Common\Infostructure\Constraint\UserStatus;

class UserFieldDto
{
    #[UserNickname([
        "groups" => ["user-nickname"]
    ])]
    #[UserStatus([
        "groups" => ["user-status"]
    ])]
    #[UserRole([
        "groups" => ["user-role"]
    ])]
    public $value;
}