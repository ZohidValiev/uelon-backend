<?php
namespace App\Context\Category\Infostructure\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Context\Category\Application\Command\Create as AppCreate;
use App\Context\Category\Application\Command\Update as AppUpdate;
use App\Context\Category\Application\Command\Delete as AppDelete;
use App\Context\Category\Application\Command\ChangePosition as AppChangePosition;
use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Doctrine\Manager;
use DomainException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CategoryDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private Manager $_em,
    )
    {}

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof AppCreate\Command
            || $data instanceof AppUpdate\Command
            || $data instanceof AppChangePosition\Command
            || $data instanceof Category;
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        try {
            if ($data instanceof AppCreate\Command) {
                return $this->_create($data);
            }
            
            if ($data instanceof AppUpdate\Command) {
                return $this->_update($data);
            }

            if ($data instanceof AppChangePosition\Command) {
                return $this->_changePosition($data);
            }
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        try {
            $this->_remove($data);
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function _create(AppCreate\Command $command): Category
    {
        $handler  = new AppCreate\Handler($this->_repository, $this->_em);
        $category = $handler->handle($command);
        
        return $category;
    }

    private function _update(AppUpdate\Command $command): Category
    {
        $handler  = new AppUpdate\Handler($this->_repository, $this->_em);
        $category = $handler->handle($command);

        return $category;
    }

    private function _changePosition(AppChangePosition\Command $command)
    {
        $handler  = new AppChangePosition\Handler($this->_em, $this->_repository);
        $category = $handler->handle($command);

        return $category;
    }

    private function _remove(Category $category)
    {
        $handler = new AppDelete\Handler($this->_em, $this->_repository);
        $handler->handle($category);
    }
}