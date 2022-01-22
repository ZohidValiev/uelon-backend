<?php
namespace App\Context\Common\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Application\Command\User\UpdateNickname\Command as NicknameCommand;
use App\Context\Common\Application\Command\User\UpdateStatus\Command as StatusCommand;
use App\Context\Common\Application\Command\User\UpdateRole\Command as RoleCommand;
use App\Context\Common\Infostructure\Dto\UserFieldDto;
use Symfony\Component\HttpFoundation\RequestStack;

class UserFieldDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private RequestStack $_requestStack,
        private ValidatorInterface $_validator,
    )
    {}

    /**
     * @param UserFieldDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $request = $this->_requestStack->getCurrentRequest();

        if ($context["item_operation_name"] === "updateNickname") {
            $object->value = \strip_tags($object->value);
            $this->_validator->validate($object, ["groups" => ["user-nickname"]]);

            $command = new NicknameCommand();
            $command->id = $request->attributes->get("id");
            $command->nickname = $object->value;
            return $command;
        }
        
        if ($context["item_operation_name"] === "updateStatus") {
            $this->_validator->validate($object, ["groups" => ["user-status"]]);

            $command = new StatusCommand();
            $command->id = $request->attributes->get("id");
            $command->status = $object->value;
            return $command;
        }

        if ($context["item_operation_name"] === "updateRole") {
            $this->_validator->validate($object, ["groups" => ["user-role"]]);

            $command = new RoleCommand();
            $command->id = $request->attributes->get("id");
            $command->role = $object->value;
            return $command;
        }
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
            && User::class === $to
            && isset($context['item_operation_name'])
            && \in_array($context['item_operation_name'], [
                'updateNickname',
                'updateStatus',
                'updateRole',
            ]);
    }
}