<?php
namespace App\Context\Category\Application\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryParentId extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Type(type: 'integer'),
            new GreaterThan(value: 0),
        ];
    }
}