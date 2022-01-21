<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Application\Command\User\UpdateNickname\Command;
use App\Context\Common\Infostructure\Dto\UserNicknameDto;
use Symfony\Component\HttpFoundation\RequestStack;

class UserNicknameDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private RequestStack $_requestStack,
        private ValidatorInterface $_validator,
    )
    {}

    /**
     * @param UserNicknameDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->_validator->validate($object);

        $request = $this->_requestStack->getCurrentRequest();

        $command = new Command();
        $command->id = $request->attributes->get("id");
        $command->nickname = $object->nickname;

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
            && User::class === $to
            && isset($context['item_operation_name'])
            && \in_array($context['item_operation_name'], [
                'updateNickname',
                'updateStatus',
            ]);
    }
}