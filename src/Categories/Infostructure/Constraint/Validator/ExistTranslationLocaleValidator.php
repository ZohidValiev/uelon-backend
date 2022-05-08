<?php
namespace App\Categories\Infostructure\Constraint\Validator;

use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Categories\Infostructure\Constraint\ExistTranslationLocale;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExistTranslationLocaleValidator extends ConstraintValidator
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private RequestStack $_requestStack,)
    {}

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ExistTranslationLocale) {
            throw new UnexpectedTypeException($constraint, ExistLanguage::class);
        }

        if ($value === null) {
            return;
        }

        $request = $this->_requestStack->getCurrentRequest();

        $locale = $value;
        $categoryId = (int)$request->attributes->get('categoryId', 0);
        if ($categoryId < 1) {
            return;
        }
        
        $exists = $this->_repository->existsTranslationLocaleBy($categoryId, $locale);

        if ($exists) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}