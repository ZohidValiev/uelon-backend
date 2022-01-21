<?php
namespace App\Context\Category\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private RequestStack $requestStack,
    )
    {}

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Category::class === $resourceClass 
            && \in_array($operationName, ['roots', 'children', 'ancestors'], true);
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if ($operationName === 'roots') {
            return $this->repository->findRoots();
        }
        
        if ($operationName === 'children') {
            $rootId = $this->requestStack
                           ->getCurrentRequest()->attributes->get('id');
            return $this->repository->findChildren($rootId);
        }

        if ($operationName === 'ancestors') {
            $id = $this->requestStack
                       ->getCurrentRequest()->attributes->get('id');
            return $this->repository->findAncestors($id);
        }
    }
}