<?php
namespace App\Context\Category\Infostructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Context\Category\Application\Command\Create\Command;
use App\Context\Category\Application\Command\Create\Translation;
use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Infostructure\Dto\CategoryCreateDto;
use App\Context\Category\Infostructure\Dto\CategoryTranslationCreateDto;


class CategoryCreateTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $validator,
    )
    {}

    /**
     * @param CategoryCreateDto $object
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->validator->validate($object);

        /**
         * @var CategoryTranslationCreateDto $translation
         */
        $translations = [];
        foreach ($object->translations as $translation)
        {
            $translations[] = new Translation(
                $translation->locale,
                $translation->title
            );
        }

        return new Command(
            $object->parentId,
            $object->icon,
            $object->isActive,
            $translations,
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data) 
                && Category::class === $to 
                && isset($context['collection_operation_name'])
                && $context['collection_operation_name'] === 'create';
    }
}