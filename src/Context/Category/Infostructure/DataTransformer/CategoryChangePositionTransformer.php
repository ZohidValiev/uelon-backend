<?php
namespace App\Context\Category\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Context\Category\Application\Command\ChangePosition\Command;
use App\Context\Category\Domain\Entity\Category;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\Validator\ValidatorInterface;

class CategoryChangePositionTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $_validator,
        private RequestStack $_requestStack,
    )
    {}

    public function transform($object, string $to, array $context = [])
    {
        $this->_validator->validate($object);
        
        $request = $this->_requestStack->getCurrentRequest();

        $command = new Command();
        $command->id = $request->attributes->get("id");
        $command->position = $object->position;

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
               && Category::class === $to
               && isset($context['item_operation_name'])
               && $context['item_operation_name'] === 'changePosition';
    }
}