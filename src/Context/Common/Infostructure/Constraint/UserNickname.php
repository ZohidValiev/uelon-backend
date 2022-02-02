<?php
namespace App\Context\Common\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class UserNickname extends Compound
{
    protected function getConstraints(array $options = []): array
    {
        return [
            new Sequentially([
                ...$options,
                "constraints" => [
                    new NotBlank(
                        allowNull: false,
                        message: "Введите значение",
                    ),
                    new Type(
                        type: "string",
                        message: "Введите строковое значение",
                    ),
                    new Length(
                        min: 2, 
                        max: 30,
                        minMessage: "Введите не менее {{ limit }} символов",
                        maxMessage: "Введите не более {{ limit }} символов",
                    ),
                ]
            ]),
        ];
    }
}