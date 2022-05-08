<?php
namespace App\Categories\Application\Command\Update;

use App\Categories\Domain\Entity\Service\CategoryUpdateService\CategoryUpdateService;
use App\Categories\Domain\Entity\Service\CategoryUpdateService\ServiceParam;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $_repository,
        private readonly CategoryUpdateService $_categoryUpdateService,
    )
    {}

    /**
     * @throws NotFoundDomainException
     */
    public function __invoke(Command $command): EntityIDInterface 
    {
        $category = $this->_repository->getByIdWithTranslations($command->id);

        $categoryUpdateService = $this->_categoryUpdateService;
        $categoryUpdateService(
            new ServiceParam(
                $category,
                $command->icon,
                $command->isActive,
                array_map(function (Translation $translation) {
                    return [
                        'locale' => $translation->locale,
                        'title' => $translation->title,
                    ];
                }, $command->translations),
            )
        );

        return $category;
    }
}