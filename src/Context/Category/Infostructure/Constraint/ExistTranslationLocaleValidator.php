<?php
namespace App\Context\Category\Infostructure\Constraint;

use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

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