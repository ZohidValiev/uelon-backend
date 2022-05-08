<?php
namespace App\Users\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class SendNotification extends Compound
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
                        message: "Введите значение",
                    ),
                    new Type(
                        type: "bool",
                        message: "Введите логическое значение",
                    ),
                ],
            ),
        ];
    }
}