<?php
namespace App\Shared\Domain\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthUserInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function getId(): ?int;

    public function getPassword(): ?string;
}