<?php
namespace App\Categories\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Categories\Domain\Entity\Category;
use App\Categories\Infostructure\Dto\CategoryChangePositionDto;
use App\Categories\Infostructure\Dto\CategoryCreateDto;
use App\Categories\Infostructure\Dto\CategoryUpdateDto;
use App\Shared\Infostructure\ApiPlatform\ContextTrait;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryInputDataTransformer implements DataTransformerInterface
{
    use ContextTrait;

    public function __construct(
        private readonly ValidatorInterface $_validator,
        private readonly RequestStack $_requestStack,
    )
    {}

    public function transform($object, string $to, array $context = [])
    {
        $request = $this->_requestStack->getCurrentRequest();
        $operationName = $this->getOperationName($context);

        switch ($operationName) {
            case CategoryOperations::OPERATION_CREATE:
                /**
                 * @var CategoryCreateDto $object
                 */
                foreach ($object->translations as $translation) {
                    $translation->locale = strip_tags($translation->locale);
                    $translation->title  = strip_tags($translation->title);
                }
                break;
            case CategoryOperations::OPERATION_UPDATE:
                /**
                 * @var CategoryUpdateDto $object
                 */
                $object->id = (int) $request->attributes->get("id");
                foreach ($object->translations as $translation) {
                    $translation->locale = strip_tags($translation->locale);
                    $translation->title  = strip_tags($translation->title);
                }
                break;
            case CategoryOperations::OPERATION_CHANGE_POSITION:
                /**
                 * @var CategoryChangePositionDto $object
                 */
                $object->id = (int) $request->attributes->get("id");
                break;
            default:
                throw new LogicException("Operation `$operationName` has not been found.");
        }

        $this->_validator->validate($object);

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        $operationName = $this->getOperationName($context);
        $operations = CategoryOperations::getInputDataTransformerOperations();

        return is_array($data) 
            && Category::class === $to 
            && in_array($operationName, $operations, true);
    }
}