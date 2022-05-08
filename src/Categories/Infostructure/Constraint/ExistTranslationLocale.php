<?php
namespace App\Categories\Infostructure\Constraint;

use Symfony\Component\Validator\Constraint;

class ExistTranslationLocale extends Constraint
{ 
    public string $message = 'This locale already exists';


    public function __construct(
        string $message = null, 
        array $options = [],
        array $groups = null, 
        $payload = null, 
    )
    {
        parent::__construct($options, $groups,  $payload) ;
        $this->message = $message ?? $this->message;
    }

    public function validatedBy()
    {
        return __NAMESPACE__ . '\Validator\ExistTranslationLocaleValidator';
    }
}