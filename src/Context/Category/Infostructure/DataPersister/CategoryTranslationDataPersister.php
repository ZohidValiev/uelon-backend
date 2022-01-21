<?php
namespace App\Context\Category\Infostructure\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Context\Category\Application\Command\Translation\Create as AppCreate;
use App\Context\Category\Application\Command\Translation\Update as AppUpdate;
use App\Context\Category\Application\Command\Translation\Delete as AppDelete;
use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use DomainException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryTranslationDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {   
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof AppCreate\Command
            || $data instanceof AppUpdate\Command
            || $data instanceof CategoryTranslation;
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
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
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
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function _create(AppCreate\Command $command): CategoryTranslation
    {
        return (new AppCreate\Handler($this->repository))->handle($command);
    }

    private function _update(AppUpdate\Command $command): CategoryTranslation
    {
        return (new AppUpdate\Handler($this->repository))->handle($command);
    }

    private function _remove(CategoryTranslation $translation)
    {
        (new AppDelete\Handler($this->repository))->handle($translation);
    }
}