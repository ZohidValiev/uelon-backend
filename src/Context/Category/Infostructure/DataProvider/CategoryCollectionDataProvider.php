<?php
namespace App\Context\Category\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\UnsupportedException;

class CategoryCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private RequestStack $requestStack,
        private Security $security,
    )
    {}

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Category::class === $resourceClass 
            && \in_array($operationName, ['roots', 'children'], true);
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $isGrantedAdmin = $this->security->isGranted("ROLE_ADMIN");

        if ($operationName === 'roots') {
            if ($isGrantedAdmin) {
                return $this->repository->findRoots();
            } else {
                return $this->repository->findRoots(active: true);
            }
        }
        
        if ($operationName === 'children') {
            $rootId = $this->requestStack
                ->getCurrentRequest()->attributes->get('id');
            
            if ($isGrantedAdmin) {
                return $this->repository->findChildren($rootId);
            } else {
                return $this->repository->findChildren(
                    id: $rootId,
                    active: true,
                );
            }
        }

        throw new LogicException("Operation `{$operationName}` is not supported.");
    }
}