<?php
namespace App\Context\Category\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Category\Application\Command\Update\Command;
use App\Context\Category\Application\Command\Update\Translation;
use App\Context\Category\Domain\Entity\Category;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryUpdateTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $_validator,
        private RequestStack $_requestStack,
    )
    {}

    /**
     * @param CategoryUpdateDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->_validator->validate($object);

        $translations = [];
        foreach ($object->translations as $translation) {
            $translations[] = new Translation(
                $translation->locale,
                $translation->title,
            );
        }

        $request = $this->_requestStack->getCurrentRequest();
        return new Command(
            $request->attributes->get('id'),
            $object->icon,
            $object->isActive,
            $translations,
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
               && Category::class === $to
               && isset($context['item_operation_name'])
               && $context['item_operation_name'] === 'update';
    }
}