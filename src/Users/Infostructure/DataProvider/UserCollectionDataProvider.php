<?php
namespace App\Users\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Users\Application\Query\User\GetNotDeletedUsers\Query;
use App\Users\Domain\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

final class UserCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @param QueryCollectionExtensionInterface[] $collectionExtensions
     */
    public function __construct(
        private readonly Pagination $_pagination,
        private readonly Security $_security,
        private readonly QueryBusInterface $_queryBus,
    )
    {}

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if (!$this->_security->isGranted(User::ROLE_ADMIN)) {
            throw new AccessDeniedException();
        }

        [$page, , $limit] = $this->_pagination->getPagination($resourceClass, $operationName, $context);
        
        return $this->_queryBus->handle(new Query($page, $limit));
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === User::class 
            && $operationName === "get"
            && $this->_pagination->isEnabled($resourceClass, $operationName, $context);
    }       
}