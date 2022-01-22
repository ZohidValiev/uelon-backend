<?php
namespace App\Context\Common\Application\Command\User\UpdateRole;


class Command 
{
    /**
     * User id
     */
    public int $id;

    /**
     * User role
     */
    public string $role;
}