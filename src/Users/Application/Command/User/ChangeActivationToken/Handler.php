<?php
namespace App\Users\Application\Command\User\ChangeActivationToken;

use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Event\EventBusInterface;
use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Event\ActivationTokenChangedDomainEvent;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\Service\EntityManagerInterface;

final class Handler
{
    public function __construct(
        private readonly UserRepositoryInterface $_repository,
        private readonly EventBusInterface $_eventBus,
    )
    {}

    /**
     * @throws NotFoundDomainException
     */
    public function __invoke(Command $command): EntityIDInterface
    {
        $user = $this->_repository->getByEmail($command->getEmail());
        $user->generateActivationToken();

        $this->_eventBus->handle(new ActivationTokenChangedDomainEvent($user));

        return $user;
    }
}
