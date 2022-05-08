<?php
namespace App\Categories\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Categories\Application\Query\FindRoots;
use App\Categories\Application\Query\FindChildren;
use App\Categories\Domain\Entity\Category;
use App\Shared\Application\Query\QueryBusInterface;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;


class CategoryCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private const OPERATION_ROOTS = "roots";
    private const OPERATION_CHILDREN = "children";

    
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly RequestStack $requestStack,
        private readonly Security $security,
    )
    {}

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Category::class === $resourceClass 
            && in_array($operationName, [
                self::OPERATION_ROOTS,
                self::OPERATION_CHILDREN,
            ], true);
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $isGrantedAdmin = $this->security->isGranted("ROLE_ADMIN");

        if ($operationName === self::OPERATION_ROOTS) {
            return $this->queryBus->handle(
                new FindRoots\Query($isGrantedAdmin ? null : true)
            );
        }
        
        if ($operationName === self::OPERATION_CHILDREN) {
            $parentId = $this->requestStack
                ->getCurrentRequest()
                ->attributes
                ->get('id');
            
            return $this->queryBus->handle(
                new FindChildren\Query($parentId, $isGrantedAdmin ? null : true)
            );
        }

        throw new LogicException("Operation `$operationName` is not supported.");
    }
}