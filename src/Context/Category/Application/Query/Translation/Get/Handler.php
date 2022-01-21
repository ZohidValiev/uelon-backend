<?php
namespace App\Context\Category\Application\Query\Translation\Get;

use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;

class Handler
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {}

    public function handle(Query $query): CategoryTranslation
    {
        return $this->repository->getTranslationBy($query->getCategoryId(), $query->getLocale());
    }
}