<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CorrectLanguageLocale extends Constraint
{
    public string $message = 'The Language locale is not correct';

    public function __construct($options = null, array $groups = null, $payload = null, string $message = null)
    {
        parent::__construct($options, $groups, $payload);
        $this->message = $message ?? $this->message;
    }
}