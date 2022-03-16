<?php
namespace App\Context\Common\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

#[\Attribute()]
class Email extends Assert\Compound
{
    protected function getConstraints(array $options = []): array
    {
        return [
            new Assert\Sequentially(
                payload: $options["payload"] ?? null,
                groups: $options["groups"] ?? [],
                constraints: [
                    new Assert\NotBlank(
                        allowNull: false,
                        message: "Введите значение",
                    ),
                    new Assert\Email(
                        message: "Введите правильный адрес",
                    ),
                ],
            ),
        ];
    }
}