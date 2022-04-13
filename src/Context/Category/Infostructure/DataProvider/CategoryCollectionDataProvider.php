<?php
namespace App\Context\Category\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Category\Application\Query\FindRoots;
use App\Context\Category\Application\Query\FindChildren;
use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;


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
            return (new FindRoots\Handler($this->repository))->handle(
                new FindRoots\Query($isGrantedAdmin ? null : true)
            );
        }
        
        if ($operationName === 'children') {
            $parentId = $this->requestStack
                ->getCurrentRequest()
                ->attributes
                ->get('id');
            
            return (new FindChildren\Handler($this->repository))->handle(
                new FindChildren\Query($parentId, $isGrantedAdmin ? null : true)
            );
        }

        throw new LogicException("Operation `$operationName` is not supported.");
    }
}