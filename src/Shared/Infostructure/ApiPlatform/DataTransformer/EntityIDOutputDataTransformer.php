<?php
namespace App\Shared\Infostructure\ApiPlatform\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Shared\Application\Dto\IdDto;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Infostructure\ApiPlatform\ContextTrait;

abstract class EntityIDOutputDataTransformer implements DataTransformerInterface
{
    use ContextTrait;

    /**
     * @param EntityIDInterface $output
     */
    public function transform($output, string $to, array $context = [])
    {
        return new IdDto($output->getId());
    }
    
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (is_array($data) || IdDto::class !== $to) {
            return false;
        }

        $operationName = $this->getOperationName($context);

        return in_array($operationName, $this->operations(), true);
    }

    /**
     * @return string[]
     */
    abstract protected function operations(): array;
}