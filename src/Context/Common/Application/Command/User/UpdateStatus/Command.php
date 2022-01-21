<?php
namespace App\Context\Common\Application\Command\User\UpdateStatus;


class Command 
{
    /**
     * User id
     */
    public int $id;

    /**
     * User status 
     */
    public int $status;
}