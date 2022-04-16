<?php
namespace App\Context\Common\Application\Command\User\ChangePassword;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Exception\InvalidPasswordDomainException;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;
use App\Util\PasswordHasher;
use Symfony\Component\Security\Core\Security;

class Handler
{
    public function __construct(
        private Security $_security, 
        private PasswordHasher $_passwordHasher,
        private Manager $_em,
    )
    {}

    public function handle(Command $command): void
    {
        /**
         * @var User
         */
        $user = $this->_security->getUser();
        if ($user === null) {
            throw new NotFoundDomainException("User has not been found.");
        }

        $isPasswordValid = $this->_passwordHasher->isPasswordValid($user, $command->getCurrentPassword());
        if (!$isPasswordValid) {
            throw new InvalidPasswordDomainException("The current password is not valid.");
        }

        $newHashedPassword = $this->_passwordHasher->hashPassword($user, $command->getNewPassword());
        $user->setPassword($newHashedPassword);
        $this->_em->flush();
    }
}