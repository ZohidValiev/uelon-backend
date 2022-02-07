<?php
namespace App\Context\Common\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class UserPasswordRepeat extends Compound
{
    protected function getConstraints(array $options = []): array
    {
        return [
            new EqualTo(
                propertyPath: "password",
                message: "Пароли не совпадают",
            )
        ];
    }
}