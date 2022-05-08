<?php
namespace App\Users\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Sequentially;

#[\Attribute]
class UserStatus extends Compound
{
    protected function getConstraints(array $options = []): array
    {
        return [
            new Sequentially(
                payload: $options["payload"] ?? null,
                groups: $options["groups"] ?? [],
                constraints: [
                    new NotBlank(
                        allowNull: false,
                        message: "Выберите значение",
                    ),
                    new Range(
                        min: 0, 
                        max: 3,
                        invalidMessage: "Выберите числовое значение",
                        notInRangeMessage: "Значение должно быть между {{ min }} и {{ max }}",
                    ),
                ],
            ),
        ];
    }
}