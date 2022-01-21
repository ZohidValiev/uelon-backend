<?php
namespace App\Doctrine\Type;

use App\Context\Common\Domain\Entity\UserActivationToken;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserActivationTokenType extends Type
{
    const TYPE = 'userActivationToken';

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
        return new UserActivationToken($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserActivationToken) {
            return $value->getValue();
        }

        return $value;
    }
}