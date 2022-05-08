<?php
namespace App\Users\Infostructure\Handler;

use App\Users\Application\Command\User\Delete\Command;
use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CommandBusInterface $_commandBus)
    {}

    public function __invoke(User $user): void
    {
        $this->_commandBus->handle(new Command($user->getId()));
    }
}