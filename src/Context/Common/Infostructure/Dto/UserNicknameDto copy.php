<?php
namespace App\Context\Common\Infostructure\Dto;

use App\Context\Common\Infostructure\Constraint\UserNickname;

class UserNicknameDto
{
    #[UserNickname()]
    public $nickname;
}