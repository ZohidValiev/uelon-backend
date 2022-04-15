<?php
namespace App\Context\Common\Application\Command\User\ChangeActivationToken;

use App\Context\Common\Application\Event\ChangedActivationTokenDomainEvent;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;
use App\Util\EventDispatcher\EventDispatcherInterface;

final class Handler
{
    public function __construct(
        private Manager $_em, 
        private UserRepositoryInterface $_repository,
        private EventDispatcherInterface $_eventDispatcher,
    )
    {}

    /**
     * @throws NotFoundDomainException
     */
    public function handle(Command $command): User
    {
        $user = $this->_em->wrapInTransaction(function() use ($command) {
            $user = $this->_repository->getByEmail($command->getEmail());
            $user->generateActivationToken();
            return $user;
        });

        $this->_eventDispatcher->dispatch(new ChangedActivationTokenDomainEvent($user));

        return $user;
    }
}
