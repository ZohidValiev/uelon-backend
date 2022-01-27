<?php
namespace App\Context\Common\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class Verification extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially([
                "groups" => $options["groups"] ?? [],
                "constraints" => [
                    new NotBlank(
                        allowNull: false,
                        message: "Введите значение",
                    ),
                    new Type(
                        type: "bool",
                        message: "Введите логическое значение",
                    ),
                ]
            ]),
        ];
    }
}