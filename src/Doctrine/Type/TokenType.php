<?php
namespace App\Doctrine\Type;

use App\Context\Common\Domain\Entity\Token;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TokenType extends Type
{
    const TYPE = 'token';

    public function getName(): string
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'VARCHAR(50)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value !== null) {
            return new Token($value);
        }
        
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Token) {
            return $value->getValue();
        }

        return $value;
    }
}