<?php
namespace App\Categories\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Sequentially;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryParentId extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                new Positive(),
                new ExistCategory(),
            ])
        ];
    }
}