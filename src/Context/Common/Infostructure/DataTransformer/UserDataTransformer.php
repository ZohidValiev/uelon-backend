<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Application\Command\User\Signup\Command as SignupCommand;
use App\Context\Common\Application\Command\User\Activate\Command as ActivateCommand;
use App\Context\Common\Application\Command\User\ChangeActivationToken\Command as ChangeActivationTokenCommand;
use App\Context\Common\Application\Command\User\Create\Command as CreateCommand;
use App\Context\Common\Application\Command\User\UpdateNickname\Command as NicknameCommand;
use App\Context\Common\Application\Command\User\UpdateStatus\Command as StatusCommand;
use App\Context\Common\Application\Command\User\UpdateRole\Command as RoleCommand;
use App\Context\Common\Application\Command\User\ChangePassword\Command as UserPasswordCommand;
use App\Context\Common\Infostructure\Dto\SignupDto;
use App\Context\Common\Infostructure\Dto\UserChangePasswordDto;
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
     * @param UserFieldDto|UserCreateDto|SignupDto|UserChangePasswordDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $request = $this->_requestStack->getCurrentRequest();
        $operation = $context["collection_operation_name"] 
            ?? $context["item_operation_name"] 
            ?? null;

        if ($operation === "signup") {
            $this->_validator->validate($object);

            return new SignupCommand(
                email: $object->email,
                password: $object->password,
            );
        }
        
        if ($operation === "activate") {
            return new ActivateCommand(
                token: $request->attributes->get("token"),
            );
        }
        
        if ($operation === "changeActivationToken") {
            $this->_validator->validate($object);

            return new ChangeActivationTokenCommand($object->email);
        }

        if ($operation === "create") {
            $object->nickname = \strip_tags($object->nickname);
            $this->_validator->validate($object);

            return new CreateCommand(
                email: $object->email,
                nickname: $object->nickname,
                password: $object->password,
                role: $object->role,
                status: $object->status,
                useVerification: $object->useVerification,
            );
        }

        if ($operation === "changePassword") {
            $this->_validator->validate($object);

            return new UserPasswordCommand(
                currentPassword: $object->currentPassword,
                newPassword: $object->password,
            );
        }

        if ($operation === "updateNickname") {
            $object->value = \strip_tags($object->value);
            $this->_validator->validate($object, ["groups" => ["user-nickname"]]);

            return new NicknameCommand(
                id: $request->attributes->get("id"),
                nickname: $object->value
            );
        }
        
        if ($operation === "updateStatus") {
            $this->_validator->validate($object, ["groups" => ["user-status"]]);

            return new StatusCommand(
                id: $request->attributes->get("id"),
                status: $object->value,
            );
        }

        if ($operation === "updateRole") {
            $this->_validator->validate($object, ["groups" => ["user-role"]]);

            return new RoleCommand(
                id: $request->attributes->get("id"),
                role: $object->value,
            );
        }
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (!(\is_array($data) && User::class === $to)) {
            return false;
        }

        $operation = $context["collection_operation_name"] 
            ?? $context["item_operation_name"] 
            ?? null;

        return \in_array($operation, [
            "signup",
            "activate",
            "changeActivationToken",
            "create",
            "changePassword",
            "updateNickname",
            "updateStatus",
            "updateRole",
        ]);
    }
}