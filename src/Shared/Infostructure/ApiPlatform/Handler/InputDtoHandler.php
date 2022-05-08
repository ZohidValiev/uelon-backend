<?php
declare(strict_types = 1);

namespace App\Shared\Infostructure\ApiPlatform\Handler;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Dto\InputDtoInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use DomainException;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Throwable;

class InputDtoHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CommandBusInterface $_commandBus)
    {}

    public function __invoke(InputDtoInterface $dto): ?EntityIDInterface
    {
        try {
            return $this->_commandBus->handle($dto->createCommand());
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (Throwable $e) {
            throw new Exception("Server exception");
        }
    }
}