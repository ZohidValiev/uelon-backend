<?php
namespace App\Context\Common\Infostructure\Dto;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignupDto
{
    #[NotBlank(allowNull: false)]
    #[Email()]
    public string $email;

    #[NotBlank(allowNull: false)]
    #[Length(min: 6)]
    public string $password;

    #[EqualTo(propertyPath: 'password')]
    public string $passwordRepeat;
}