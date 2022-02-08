<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute]
class LanguageLocale extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Sequentially(
                groups: [],
                constraints: [
                    new NotBlank(
                        allowNull: false,
                    ),
                    new Type('string'),
                    new CorrectLanguageLocale(),
                    new ExistTranslationLocale(),
                ],
            ),
        ];
    }
}