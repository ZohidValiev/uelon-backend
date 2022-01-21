<?php
namespace App\Context\Category\Application\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryIsActive extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new NotNull(),
            new Type(type: 'boolean'),
        ];
    }
}