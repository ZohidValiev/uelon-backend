<?php
namespace App\Context\Common\Infostructure\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Common\Application\Query\User\GetByUsername\Query;
use App\Context\Common\Application\Query\User\GetByUsername\Handler;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Infostructure\Dto\SigninInputDto;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

final class UserByUsernameItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private Handler $handler,
        private RequestStack $requestStack,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    )
    {}

    public function getItem(string $resourceClass, $ids, string $operationName = null, array $context = [])
    {
        $request = $this->requestStack->getCurrentRequest();
        try {
            $inputDto = $this->serializer
                ->deserialize($request->getContent(), SigninInputDto::class, 'json');
        } catch (\Throwable $th) {
            throw new BadRequestHttpException("Incorrect request body");
        }

        $this->validator->validate($inputDto);

        $query = new Query($inputDto->username, $inputDto->password);
        return $this->handler->handle($query);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return (User::class === $resourceClass) && ($operationName === 'signin');
    }
}