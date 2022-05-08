<?php
namespace App\Categories\Infostructure\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ExistCategory extends Constraint
{
    public string $message = 'The category does not exist';

    public function validatedBy()
    {
        return __NAMESPACE__ . '\Validator\ExistCategoryValidator';
    }
}