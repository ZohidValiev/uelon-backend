<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Application\Command\User\Create\Command as CreateUserCommand;
use App\Context\Common\Application\Command\User\UpdateNickname\Command as NicknameCommand;
use App\Context\Common\Application\Command\User\UpdateStatus\Command as StatusCommand;
use App\Context\Common\Application\Command\User\UpdateRole\Command as RoleCommand;
use App\Context\Common\Infostructure\Dto\UserCreateDto;
use App\Context\Common\Infostructure\Dto\UserFieldDto;
use Symfony\Component\HttpFoundation\RequestStack;

class UserDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private RequestStack $_requestStack,
        private ValidatorInterface $_validator,
    )
    {}

    /**
     * @param UserFieldDto|UserCreateDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $request = $this->_requestStack->getCurrentRequest();
        $operation = $context["collection_operation_name"] 
            ?? $context["item_operation_name"] 
            ?? null;

        if ($operation === "create") {
            $object->nickname = \strip_tags($object->nickname);
            $this->_validator->validate($object);

            $command = new CreateUserCommand();
            $command->email = $object->email;
            $command->nickname = $object->nickname;
            $command->password = $object->password;
            $command->role = $object->role;
            $command->status = $object->status;
            $command->useVerification = $object->useVerification;
            return $command;
        }

        if ($operation === "updateNickname") {
            $object->value = \strip_tags($object->value);
            $this->_validator->validate($object, ["groups" => ["user-nickname"]]);

            $command = new NicknameCommand();
            $command->id = $request->attributes->get("id");
            $command->nickname = $object->value;
            return $command;
        }
        
        if ($operation === "updateStatus") {
            $this->_validator->validate($object, ["groups" => ["user-status"]]);

            $command = new StatusCommand();
            $command->id = $request->attributes->get("id");
            $command->status = $object->value;
            return $command;
        }

        if ($operation === "updateRole") {
            $this->_validator->validate($object, ["groups" => ["user-role"]]);

            $command = new RoleCommand();
            $command->id = $request->attributes->get("id");
            $command->role = $object->value;
            return $command;
        }
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (!\is_array($data) && User::class !== $to) {
            return false;
        }

        $operation = $context["collection_operation_name"] 
            ?? $context["item_operation_name"] 
            ?? null;

        return \in_array($operation, [
            'create',
            'updateNickname',
            'updateStatus',
            'updateRole',
        ]);
    }
}