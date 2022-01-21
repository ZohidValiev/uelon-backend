<?php
namespace App\Context\Common\Domain\Entity;


class UserEmail
{
    private string $value;

    public function __construct(string $email)
    {
        if ($email === null || \mb_strlen($email) === 0) {
            throw new \InvalidArgumentException('Field email cannot be null or empty.');
        }

        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getNickname(): string
    {
        return \mb_substr($this->value, 0, \mb_strpos($this->value, '@'));
    }
}