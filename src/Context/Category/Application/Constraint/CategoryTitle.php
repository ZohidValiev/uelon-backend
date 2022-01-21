<?php
namespace App\Context\Category\Application\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryTitle extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                new NotBlank(allowNull: false),
                new Type(type: 'string'),
                new Length(min: 2, max: 50),
            ]),
        ];
    }
}