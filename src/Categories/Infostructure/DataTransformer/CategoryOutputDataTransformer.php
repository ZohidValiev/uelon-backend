<?php
namespace App\Categories\Infostructure\DataTransformer;

use App\Shared\Infostructure\ApiPlatform\DataTransformer\EntityIDOutputDataTransformer;

class CategoryOutputDataTransformer extends EntityIDOutputDataTransformer
{
    protected function operations(): array
    {
        return CategoryOperations::getOutputDataTransformerOperations();
    }   
}