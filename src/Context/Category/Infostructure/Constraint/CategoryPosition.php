<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Sequentially;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryPosition extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                new NotNull(
                    message: "Введите значение",
                ),
                new Positive(
                    message: "Введите числовое значение",
                ),
            ])
        ];
    }
}