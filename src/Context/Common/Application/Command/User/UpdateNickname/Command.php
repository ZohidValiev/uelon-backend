<?php
namespace App\Context\Common\Application\Command\User\UpdateNickname;


class Command 
{
    /**
     * User id
     */
    public int $id;

    /**
     * Use nickname
     */
    public string $nickname;
}