<?php
namespace App\Context\Common\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Common\Application\Query\User\GetByToken\Query;
use App\Context\Common\Application\Query\User\GetByToken\Handler;
use App\Context\Common\Domain\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;

class UserByTokenItemDataProvider implements DenormalizedIdentifiersAwareItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private Handler $handler,
        private RequestStack $requestStack,
    )
    {}

    public function getItem(string $resourceClass, $ids, string $operationName = null, array $context = [])
    {
        $token = $this->requestStack
            ->getCurrentRequest()
            ->attributes
            ->get('token');

        return $this->handler->handle(new Query($token));
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass
            && isset($context['item_operation_name']) 
            && ($context['item_operation_name'] === 'activate');
    }
}