<?php
namespace App\Context\Category\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Context\Category\Application\Query\Translation\Get\Handler;
use App\Context\Category\Application\Query\Translation\Get\Query;
use App\Context\Category\Domain\Entity\CategoryTranslation;


class CategoryTranslationItemDataProvider implements DenormalizedIdentifiersAwareItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(private Handler $handler)
    {}

    public function getItem(string $resourceClass, $ids, string $operationName = null, array $context = [])
    {
        return $this->handler->handle(new Query($ids['categoryId'], $ids['locale']));
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CategoryTranslation::class === $resourceClass
            && isset($context['item_operation_name']) 
            && ($context['item_operation_name'] === 'get' || $context['item_operation_name'] === 'delete');
    }
}