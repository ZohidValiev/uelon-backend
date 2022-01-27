<?php
namespace App\Context\Common\Application\Command\User\Create;


class Command 
{
    /**
     * User email
     */
    public string $email;

    /**
     * User nickname
     */
    public string $nickname;

    /**
     * User role
     */
    public string $role;

    /**
     * User password
     */
    public string $password;

    /**
     * User status
     */
    public int $status;

    public bool $useVerification;
}