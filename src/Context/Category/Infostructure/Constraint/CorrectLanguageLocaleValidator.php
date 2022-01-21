<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CorrectLanguageLocaleValidator extends ConstraintValidator
{
    public const LANGUAGE_LOCALE_UZ = 'uz';
    public const LANGUAGE_LOCALE_RU = 'ru';

    private const LANGUAGE_LOCALES = [
        self::LANGUAGE_LOCALE_UZ,
        self::LANGUAGE_LOCALE_RU,
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