<?php
namespace App\Context\Category\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CorrectLanguageLocale extends Constraint
{
    public string $message = 'The Language locale is not correct';

    public function __construct(string $message = null)
    {
        $this->message = $message ?? $this->message;
    }
}