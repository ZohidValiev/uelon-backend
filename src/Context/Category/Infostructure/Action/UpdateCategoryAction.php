<?php
namespace App\Context\Category\Infostructure\Action;

use App\Context\Category\Application\Command\Update\Command;
use App\Context\Category\Application\Command\Update\Handler;
use App\Context\Category\Domain\Entity\Category;


class UpdateCategoryAction
{
    public function __construct(
        private Handler $_handler,
    )
    {
        
    }

    public function __invoke(Command $data): Category
    {
        return $this->_handler->handle($data);
    }
}