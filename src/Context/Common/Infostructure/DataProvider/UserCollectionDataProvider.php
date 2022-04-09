<?php
namespace App\Context\Common\Infostructure\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

final class UserCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private array $collectionExtensions;

    /**
     * @param QueryCollectionExtensionInterface[] $collectionExtensions
     */
    public function __construct(
        private UserRepositoryInterface $repository,
        private RequestStack $requestStack,
        private Pagination $pagination,
        private Security $security,
    )
    {}

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if (!$this->security->isGranted(User::ROLE_ADMIN)) {
            throw new AccessDeniedException();
        }

        [$page, , $limit] = $this->pagination->getPagination($resourceClass, $operationName, $context);
        
        return $this->repository->getNotDeletedUsers(
            page: $page,
            itemsPerPage: $limit,
        );
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === User::class 
            && $operationName === "get"
            && $this->pagination->isEnabled($resourceClass, $operationName, $context);
    }       
}