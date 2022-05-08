<?php
namespace App\Categories\Infostructure\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Categories\Application\Command\Create;
use App\Categories\Application\Command\Update;
use App\Categories\Application\Command\Delete;
use App\Categories\Application\Command\ChangePosition;
use App\Categories\Domain\Entity\Category;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use DomainException;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {}

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Create\Command
            || $data instanceof Update\Command
            || $data instanceof ChangePosition\Command
            || $data instanceof Category;
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        try {
            $this->commandBus->handle($data);
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw new Exception("Server exception");
        }
    }

    /**
     * {@inheritdoc}
     * @param Category $data
     */
    public function remove($data, array $context = [])
    {
        try {
            $this->commandBus->handle(new Delete\Command($data->getId()));
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw new Exception("Server exception");
        }
    }
}