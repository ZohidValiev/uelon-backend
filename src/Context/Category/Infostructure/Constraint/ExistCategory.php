<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;

class ExistCategory extends Constraint
{
    public string $message = 'The category does not exist';
}