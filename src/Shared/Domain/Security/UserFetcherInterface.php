<?php
namespace App\Shared\Domain\Security;


interface UserFetcherInterface
{
    public function getAuthUser(): AuthUserInterface;
}