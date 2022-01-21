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

        $request = $this->_requestStack->getCurrentRequest();
        
        $command = new Command();
        $command->id       = $request->attributes->get('id');
        $command->icon     = $object->icon;
        $command->isActive = $object->isActive;
        
        foreach ($object->translations as $translation) {
            $commandTranslation = new Translation();
            $commandTranslation->locale = $translation->locale;
            $commandTranslation->title  = $translation->title;
            $command->translations[]    =  $commandTranslation;
        }


        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return \is_array($data)
               && Category::class === $to
               && isset($context['item_operation_name'])
               && $context['item_operation_name'] === 'update';
    }
}