<?php
namespace App\Context\Common\Domain\Entity;

use App\Util\Random;

class Token
{
    private string $value;

    private ?int $_expireTime = null;

    public function __construct(?string $token)
    {
        $this->value = $token;
    }

    public static function generate(int $time): Token
    {
        $token = Random::generateRandomString() . '_' . (\time() + $time);
        return new Token($token);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isExpired(): bool
    {
        $this->_parse();
        return $this->_expireTime < \time();
    }

    public function getExpireTime(): \DateTimeImmutable
    {
        $this->_parse();
        return (new \DateTimeImmutable())->setTimestamp($this->_expireTime);
    }

    private function _parse(): void
    {
        if ($this->value === null || $this->_expireTime >= 0) {
            return;
        }

        $expireTime = \substr($this->value, \strpos($this->value, '_') + 1);

        if ($expireTime === '') {
            throw new \UnexpectedValueException('An expiration time must be present');
        }

        $this->_expireTime = (int) $expireTime;
    }
}