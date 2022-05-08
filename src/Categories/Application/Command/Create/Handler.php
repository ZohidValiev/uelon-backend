<?php
namespace App\Categories\Application\Command\Create;

use App\Categories\Domain\Entity\Service\CategoryCreateService\CategoryCreateService;
use App\Categories\Domain\Entity\Service\CategoryCreateService\ServiceParam;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(private CategoryCreateService $_categoryCreateService)
    {}
    
    public function __invoke(Command $command): EntityIDInterface
    {
        $categoryCreateService = $this->_categoryCreateService;
        $category = $categoryCreateService(
            new ServiceParam(
                $command->icon, 
                $command->isActive, 
                array_map(function (Translation $translation) {
                    return [
                        "locale" => $translation->locale,
                        "title" => $translation->title,
                    ];
                }, $command->translations), 
                $command->parentId
            )
        );

        return $category;
    }
}