<?php
namespace App\Users\Domain\Entity;


class UserStatus
{
    const STATUS_DELETED  = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE   = 2;
    const STATUS_BLOCKED  = 3;

    private int $value;

    public function __construct(int $status)
    {
        $this->value = $status;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isInactive(): bool
    {
        return $this->value === self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->value === self::STATUS_ACTIVE;
    }

    public function setAsActive(): void
    {
        $this->value = self::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->value === self::STATUS_BLOCKED;
    }

    public function setAsBlocked(): void
    {
        $this->value = self::STATUS_BLOCKED;
    }

    public function isDeleted(): bool
    {
        return $this->value === self::STATUS_DELETED;
    }

    public function setAsDeleted(): void
    {
        $this->value = self::STATUS_DELETED;
    }
}