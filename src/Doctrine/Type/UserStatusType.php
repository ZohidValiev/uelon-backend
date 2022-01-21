<?php
namespace App\Doctrine\Type;

use App\Context\Common\Domain\Entity\UserStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserStatusType extends Type
{
    const TYPE = 'userStatus';

    public function getName()
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'tinyint(1)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserStatus($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserStatus) {
            return $value->getValue();
        }

        return $value;
    }
}