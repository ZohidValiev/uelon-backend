<?php
namespace App\Context\Category\Application\Command\Translation\Delete;

use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Doctrine\Manager;

class Handler 
{
    public function __construct(private Manager $_em)
    {}

    public function handle(CategoryTranslation $translation)
    {
        $category = $translation->getCategory();

        $category->removeTranslation($translation);

        $this->_em->flush();
    }
}