<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Infostructure\Dto\SignupDto;
use App\Context\Common\Application\Command\User\Signup\Command;

class SignupDataTransformer implements DataTransformerInterface
{
    public function __construct(private ValidatorInterface $_validator)
    {}

    /**
     * @param SignupDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->_validator->validate($object);

        $command = new Command();
        $command->email    = $object->email;
        $command->password = $object->password;

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
            && User::class === $to
            && isset($context['collection_operation_name'])
            && $context['collection_operation_name'] === 'signup';
    }
}