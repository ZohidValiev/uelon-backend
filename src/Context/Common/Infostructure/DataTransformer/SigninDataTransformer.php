<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Infostructure\Dto\SigninInputDto;
use App\Context\Common\Infostructure\Dto\SigninOutputDto;

final class SigninDataTransformer implements DataTransformerInterface
{
    public function __construct(private ValidatorInterface $_validator)
    {}

    /**
     * @param SigninInputDto|User $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $dto = new SigninOutputDto();
        $dto->id = $object->getId();
        $dto->username = $object->getEmail();
        $dto->nickname = $object->getNickname();
        return $dto;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SigninOutputDto::class === $to && $data instanceof User;
    }
}