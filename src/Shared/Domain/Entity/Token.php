<?php
namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Util\Random;
use DateTimeImmutable;
use UnexpectedValueException;
use function substr;
use function strpos;
use function time;

class Token
{
    private const DELIMITER = "_";

    private string $value;
    private ?DateTimeImmutable $expireTime = null;

    public function __construct(string $token)
    {
        $this->value = $token;
    }

    public static function generate(int $time = 24 * 3600): Token
    {
        $token = Random::generateString() . self::DELIMITER . (time() + $time);
        return new self($token);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isExpired(): bool
    {
        return $this->getExpireTime()->getTimestamp() < time();
    }

    public function getExpireTime(): \DateTimeImmutable
    {
        if ($this->expireTime === null) {
            $this->expireTime = (new DateTimeImmutable())
                ->setTimestamp($this->_getExpireTimestamp($this->value));
        }

        return $this->expireTime;
    }

    private function _getExpireTimestamp(string $token): int
    {
        $expireTime = substr($token, strpos($token, self::DELIMITER) + 1);

        if ($expireTime === "" || $expireTime === false) {
            throw new UnexpectedValueException("Expiration time must be present");
        }

        return (int)$expireTime;
    }
}