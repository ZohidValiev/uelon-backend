<?php
namespace App\Shared\Infostructure\Database\ORM\Type;

use App\Shared\Domain\Entity\Token;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TokenType extends Type
{
    const TYPE = 'token';

    public function getName(): string
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(50)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value !== null) {
            return new Token($value);
        }
        
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof Token) {
            return $value->getValue();
        }

        return $value;
    }
}