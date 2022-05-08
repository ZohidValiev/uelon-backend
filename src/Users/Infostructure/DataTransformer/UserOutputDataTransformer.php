<?php
namespace App\Users\Infostructure\DataTransformer;

use App\Shared\Infostructure\ApiPlatform\DataTransformer\EntityIDOutputDataTransformer;

class UserOutputDataTransformer extends EntityIDOutputDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function operations(): array
    {
        return UserOperations::getOutputDataTransformerOperations();
    }
}