<?php
namespace App\Users\Application\Command\User\ChangePassword;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\InvalidPasswordDomainException;
use App\Users\Domain\Service\EntityManagerInterface;
use App\Users\Domain\Service\PasswordHasherInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private UserFetcherInterface $userFetcher, 
        private PasswordHasherInterface $passwordHasher,
    )
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        /**
         * @var User
         */
        $user = $this->userFetcher->getAuthUser();
        
        NotFoundDomainException::notNull($user, "User by id = {$user->getId()} has not been found.");

        $isPasswordValid = $this->passwordHasher->isPasswordValid($user, $command->getCurrentPassword());
        if (!$isPasswordValid) {
            throw new InvalidPasswordDomainException("The current password is not valid.");
        }

        $user->setPassword($this->passwordHasher, $command->getNewPassword());
        
        return $user;
    }
}