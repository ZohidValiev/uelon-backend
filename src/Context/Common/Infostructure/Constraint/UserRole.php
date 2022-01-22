<?php
namespace App\Context\Common\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class UserRole extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                "groups" => $options["groups"] ?? [],
                "constraints" => [
                    new NotBlank(
                        allowNull: false,
                        message: "Выберите значение",
                    ),
                    new Type(
                        type: "string",
                        message: "Введите строковое значение",
                    ),
                    new Regex(
                        pattern: "/^(ROLE_USER|ROLE_MODERATOR|ROLE_ADMIN)$/",
                        message: "Выбрано неправильное значение",
                    ),
                ]
            ]),
        ];
    }
}