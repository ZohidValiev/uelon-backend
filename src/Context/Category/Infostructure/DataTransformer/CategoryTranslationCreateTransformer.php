<?php
namespace App\Context\Category\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Category\Application\Command\Translation\Create\Command;
use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Infostructure\Dto\CategoryTranslationCreateDto;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryTranslationCreateTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $_validator,
        private RequestStack $_requestStack,
    )
    {
        
    }

    /**
     * @param CategoryTranslationCreateDto
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->_validator->validate($object);

        $request = $this->_requestStack->getCurrentRequest();

        $command = new Command();
        $command->categoryId = (int)$request->attributes->get('categoryId', 0);
        $command->locale     = $object->locale;
        $command->title      = $object->title;

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data) 
                && CategoryTranslation::class === $to 
                && isset($context['collection_operation_name'])
                && $context['collection_operation_name'] === 'create';
    }
}