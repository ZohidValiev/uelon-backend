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

        $command = new Command();
        $command->parentId = $object->parentId;
        $command->icon = $object->icon;
        $command->isActive = $object->isActive;
        $command->translations = [];

        /**
         * @var CategoryTranslationCreateDto $translation
         */
        foreach ($object->translations as $translation)
        {
            $commandTranslation = new Translation();
            $commandTranslation->locale = $translation->locale;
            $commandTranslation->title = $translation->title;
            $command->translations[] = $commandTranslation;
        }

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data) 
                && Category::class === $to 
                && isset($context['collection_operation_name'])
                && $context['collection_operation_name'] === 'create';
    }
}