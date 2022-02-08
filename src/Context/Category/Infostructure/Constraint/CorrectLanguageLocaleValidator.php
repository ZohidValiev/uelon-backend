<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CorrectLanguageLocaleValidator extends ConstraintValidator
{
    private const LANGUAGE_LOCALES = [
        "uz",
        "ru",
    ];

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CorrectLanguageLocale) {
            throw new UnexpectedTypeException($constraint, CorrectLanguageLocale::class);
        }

        if ($value === null) {
            return;
        }

        if (!\is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $value = \strtolower($value);

        if (!\in_array($value, self::LANGUAGE_LOCALES)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}