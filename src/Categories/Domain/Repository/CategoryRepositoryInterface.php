<?php
namespace App\Categories\Domain\Repository;

use App\Categories\Domain\Entity\Category;
use App\Categories\Domain\Entity\CategoryTranslation;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Shared\Exception\NotFoundDomainException;

interface CategoryRepositoryInterface extends RepositoryInterface
{
   public function find($id, $lockMode = null, $lockVersion = null);
   
   /**
    * @throws NotFoundDomainException
    */
   public function getById(int $id): Category;

   public function findByParentIdAndGreaterThanPosition(?int $parentId, int $position): array;

   public function getNextPosition(?int $parentId = null): int;

   public function findRoots(bool $active = null): array;

   public function findChildren(int $id, bool $active = null): array;

   public function findAncestors(int $childId): iterable;

   public function findByIdWithTranslations(int $id): ?Category;

   public function getByIdWithTranslations(int $id): Category;

   public function getTranslationBy(int $categoryId, string $locale): CategoryTranslation;

   public function exists(int $id): bool;

   public function existsTranslationLocaleBy(int $categoryId, string $locale): bool;

}