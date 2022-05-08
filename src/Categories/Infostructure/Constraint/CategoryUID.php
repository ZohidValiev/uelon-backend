<?php
namespace App\Categories\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Sequentially;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CategoryUID extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                new NotNull(
                    message: "Значение не может быть null",
                ),
                new Positive(
                    message: "Значение должно быть позитивным числом",
                ),
            ])
        ];
    }
}