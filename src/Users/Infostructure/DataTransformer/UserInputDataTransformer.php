<?php
namespace App\Users\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Shared\Infostructure\ApiPlatform\ContextTrait;
use App\Users\Domain\Entity\User;
use App\Users\Infostructure\Dto\SignupDto;
use App\Users\Infostructure\Dto\UserActivateDto;
use App\Users\Infostructure\Dto\UserChangePasswordDto;
use App\Users\Infostructure\Dto\UserCreateDto;
use App\Users\Infostructure\Dto\UserFieldDto;
use App\Users\Infostructure\Dto\UserUpdateNicknameDto;
use App\Users\Infostructure\Dto\UserUpdateRoleDto;
use App\Users\Infostructure\Dto\UserUpdateStatusDto;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;

class UserInputDataTransformer implements DataTransformerInterface
{
    use ContextTrait;

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
        $operationName = $this->getOperationName($context);

        switch ($operationName) {
            case UserOperations::OPERATION_SIGNUP:
            case UserOperations::OPERATION_CHANGE_ACTIVATION_TOKEN:
            case UserOperations::OPERATION_CHANGE_PASSWORD:
                break;
            case UserOperations::OPERATION_ACTIVATE:
                /**
                 * @var UserActivateDto $object
                 */
                $object->token = $request->attributes->get("token");
                break;
            case UserOperations::OPERATION_CREATE:
                /**
                 * @var UserCreateDto $object
                 */
                $object->nickname = strip_tags($object->nickname);
                break;
            case UserOperations::OPERATION_UPDATE_NICKNAME:
                /**
                 * @var UserUpdateNicknameDto $object
                 */
                $object->id = (int) $request->attributes->get("id");
                $object->nickname = strip_tags($object->nickname);
                break;
            case UserOperations::OPERATION_UPDATE_STATUS:
                /**
                 * @var UserUpdateStatusDto $object
                 */
                $object->id = (int) $request->attributes->get("id");
                break;
            case UserOperations::OPERATION_UPDATE_ROLE:
                /**
                 * @var UserUpdateRoleDto $object
                 */
                $object->id = $request->attributes->get("id");
                break;
            default:
                throw new LogicException("Operation `$operationName` has not been found.");
        }

        $this->_validator->validate($object);

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (!(is_array($data) && User::class === $to)) {
            return false;
        }

        $operationName = $this->getOperationName($context);

        return in_array($operationName, UserOperations::getInputDataTransformerOperations(), true);
    }
}