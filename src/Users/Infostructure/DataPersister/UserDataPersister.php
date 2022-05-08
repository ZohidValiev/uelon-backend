<?php
namespace App\Users\Infostructure\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Users\Application\Command\User\Signup as Signup;
use App\Users\Application\Command\User\Create as Create;
use App\Users\Application\Command\User\Activate as Activate;
use App\Users\Application\Command\User\ChangeActivationToken as ChangeActivationToken;
use App\Users\Application\Command\User\UpdateNickname as UpdateNickname;
use App\Users\Application\Command\User\UpdateStatus as UpdateStatus;
use App\Users\Application\Command\User\UpdateRole as UpdateRole;
use App\Users\Application\Command\User\Delete as Delete;
use App\Users\Domain\Entity\User;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use App\Shared\Infostructure\ApiPlatform\ContextTrait;
use App\Shared\Infostructure\Dto\IdDto;
use DomainException;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    use ContextTrait;

    public function __construct(private readonly CommandBusInterface $_commandBus)
    {}

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return false;
        return $data instanceof Signup\Command
            || $data instanceof Activate\Command
            || $data instanceof ChangeActivationToken\Command
            || $data instanceof Create\Command
            || $data instanceof UpdateNickname\Command
            || $data instanceof UpdateStatus\Command
            || $data instanceof UpdateRole\Command
            || ($data instanceof User && $this->getItemOperationName($context) === "delete");
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        try {
            return $this->_commandBus->handle($data);
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (\Throwable $e) {
            throw new Exception("Server exception");
        }
    }

    /**
     * {@inheritdoc}
     * @param User $data
     */
    public function remove($data, array $context = [])
    {
        try {
            $this->_commandBus->handle(new Delete\Command($data->getId()));
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw new Exception("Server exception");
        }
    }
}