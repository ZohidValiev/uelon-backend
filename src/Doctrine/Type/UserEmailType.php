<?php
namespace App\Doctrine\Type;

use App\Context\Common\Domain\Entity\UserEmail;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserEmailType extends Type
{
    const TYPE = 'email';

    public function getName()
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'VARCHAR(255)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserEmail($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserEmail) {
            return $value->getValue();
        }

        return $value;
    }
}