<?php
namespace App\Categories\Infostructure\Handler;

use App\Categories\Application\Command\Delete\Command;
use App\Categories\Domain\Entity\Category;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CommandBusInterface $_commandBus)
    {}

    public function __invoke(Category $category): void
    {
        $this->_commandBus->handle(new Command($category->getId()));
    }
}