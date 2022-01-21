<?php
namespace App\Context\Category\Infostructure\Constraint;

use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExistCategoryValidator extends ConstraintValidator
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ExistCategory) {
            throw new UnexpectedTypeException($constraint, ExistCategory::class);
        }

        if ($value === null || $value < 1) {
            return;
        }

        $exists = $this->_repository->exists($value);

        if (!$exists) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}