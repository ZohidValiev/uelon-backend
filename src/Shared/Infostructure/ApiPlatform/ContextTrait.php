<?php
namespace App\Shared\Infostructure\ApiPlatform;


trait ContextTrait
{
    public function getOperationName(array $context): ?string
    {
        return $this->getCollectionOperationName($context) ?? $this->getItemOperationName($context) ?? null;
    }

    public function getCollectionOperationName(array $context): ?string
    {
        return $context["collection_operation_name"] ?? null;
    }
    
    public function getItemOperationName(array $context): ?string
    {
        return $context["item_operation_name"] ?? null;
    }
}