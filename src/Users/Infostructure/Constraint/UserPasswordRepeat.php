<?php
namespace App\Users\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\EqualTo;

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