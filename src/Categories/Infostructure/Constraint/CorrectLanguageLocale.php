<?php
namespace App\Categories\Infostructure\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CorrectLanguageLocale extends Constraint
{
    public string $message = 'The Language locale is incorrect';

    public function __construct($options = null, array $groups = null, $payload = null, string $message = null)
    {
        parent::__construct($options, $groups, $payload);
        $this->message = $message ?? $this->message;
    }

    public function validatedBy()
    {
        return __NAMESPACE__ . '\Validator\CorrectLanguageLocaleValidator';
    }
}