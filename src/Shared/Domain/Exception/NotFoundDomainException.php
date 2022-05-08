<?php
namespace App\Shared\Domain\Exception;

use DomainException;
use Throwable;

class NotFoundDomainException extends DomainException
{
    public static function notNull(
        object $entity, 
        string $message, 
        int $code = 0, 
        Throwable|null $previous = null,
    ): void
    {
        if ($entity === null) {
            throw new self($message, $code, $previous);
        }
    }
}