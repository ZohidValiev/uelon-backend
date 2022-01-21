<?php
namespace App\Context\Category\Domain\Repository;

use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Common\Domain\Repository\RepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use Doctrine\ORM\EntityManagerInterface;

interface CategoryRepositoryInterface
{
   public function find($id, $lockMode = null, $lockVersion = null);
   
   /**
    * @throws NotFoundDomainException
    */
   public function get($id, $lockMode = null, $lockVersion = null): Category;

   public function findByParentIdAndGreaterThanPosition(?int $parentId, int $position): array;

   public function getNextPosition(?int $parentId = null): int;

   public function findRoots(): array;

   public function findChildren(int $id): array;

   public function findAncestors(int $childId): iterable;

   public function findByIdWithTranslations(int $id): ?Category;

   public function getByIdWithTranslations(int $id): Category;

   public function getTranslationBy(int $categoryId, string $locale): CategoryTranslation;

   public function exists(int $id): bool;

   public function existsTranslationLocaleBy(int $categoryId, string $locale): bool;

}