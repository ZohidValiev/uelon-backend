<?php
namespace App\Context\Category\Infostructure\Repository;

use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $lockMode = null, $lockVersion = null): Category
    {
        $category = $this->find($id, $lockMode, $lockVersion);

        if ($category == null) {
            throw new NotFoundDomainException("Category with id = $id has not been found.");
        }

        return $category;
    }

    public function findByParentIdAndGreaterThanPosition(?int $parentId, int $position): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select("c")
           ->from(Category::class, "c")
           ->orderBy("c.position", "ASC")
           ->where("c.position > :position")
           ->setParameters([
               "position" => $position,
           ]);
        
        if ($parentId === null) {
            $qb->andWhere("c.parent IS NULL");
        } else {
            $qb->andWhere("c.parent = :parentId")
               ->setParameters([
                   "parentId" => $parentId,
               ]);
        }

        return $qb->getQuery()->getResult();
    }

    public function getNextPosition(?int $parentId = null): int
    {
        /**
         * @var QueryBuilder $qb
         */
        $qb = $this->_em->getConnection()->createQueryBuilder();
        $qb->select("COUNT(c.position) + 1");
        $qb->from("tbl_category", "c");

        if ($parentId == null) {
            $qb->where("c.parent_Id IS NULL");
        } else {
            $qb->where("c.parent_id = :parentId");
            $qb->setParameters([
                "parentId" => $parentId,
            ]);
        }
        
        return (int)$qb->fetchOne();
        // return (int)$qb->execute()->fetchOne();
    }

    public function findRoots(bool $active = null): array
    {
        $qb = $this->createQueryBuilder("c")
            ->where("c.parent IS NULL")
            ->orderBy("c.position", "ASC");

        if ($active !== null) {
            $qb->andWhere("c.isActive = :isActive");
            $qb->setParameter("isActive", $active);
        }

        return $qb->getQuery()->getResult();

        // $dql = <<<DQL
        //     SELECT c FROM App\Context\Category\Domain\Entity\Category c
        //     WHERE c.parent IS NULL
        //     ORDER BY c.position ASC
        // DQL;

        // return $this->_em
        //             ->createQuery($dql)
        //             ->getResult();
    }

    public function findChildren(int $id, bool $active = null): array
    {
        if ($id < 1) {
            return [];
        }

        $qb = $this->createQueryBuilder("c")
            ->where("c.parent = :id")
            ->orderBy("c.position", "ASC")
            ->setParameter("id", $id);

        if ($active !== null) {
            $qb->andWhere("c.isActive = :isActive");
            $qb->setParameter("isActive", $active);
        }

        return $qb->getQuery()->getResult();

        // $dql = <<<DQL
        //     SELECT c FROM App\Context\Category\Domain\Entity\Category c
        //     WHERE c.parent = :id
        //     ORDER BY c.position ASC
        // DQL;

        // return $this->_em
        //             ->createQuery($dql)
        //             ->setParameter('id', $id)
        //             ->getResult();
    }

    /**
     * @param int $childId
     * @return iterable<Category>
     */
    public function findAncestors(int $childId): iterable
    {
        $dql = <<<DQL
            SELECT c FROM App\Context\Category\Domain\Entity\Category c
            WHERE c.id IN (
                SELECT parent.id FROM App\Context\Category\Domain\Entity\CategoryRelation cr
                JOIN cr.parent parent
                JOIN cr.child  child
                WHERE child.id = :childId
            )
        DQL;

        return $this->_em->createQuery($dql)
                         ->setParameter('childId', $childId)
                         ->getResult();
    }

    public function findByIdWithTranslations(int $id): ?Category
    {
        if ($id < 1) {
            return null;
        }

        $dql = <<<DQL
            SELECT c, t FROM App\Context\Category\Domain\Entity\Category c
            LEFT JOIN c.translations t
            WHERE c.id = :id
        DQL;

        return $this->_em->createQuery($dql)
                    ->setParameter('id', $id)
                    ->getOneOrNullResult();
    }

    public function getByIdWithTranslations(int $id): Category
    {
        $category = $this->findByIdWithTranslations($id);

        if ($category == null) {
            throw new NotFoundDomainException("Category with id = $id has not been found.");
        }

        return $category;
    }

    public function getTranslationBy(int $categoryId, string $locale): CategoryTranslation
    {
        $dql = <<<DQL
            SELECT t FROM App\Context\Category\Domain\Entity\CategoryTranslation t
            WHERE t.category = :cid AND t.locale = :locale
        DQL;

        $translation = $this->_em->createQuery($dql)
                  ->setParameters([
                      'cid' => $categoryId,
                      'locale' => $locale,
                  ])
                  ->getOneOrNullResult();

        if ($translation == null) {
            throw new NotFoundDomainException("Translation has not been found");
        }

        return $translation;
    }

    public function exists(int $id): bool
    {
        $subSql = <<<SQL
            SELECT 1 FROM tbl_category c
            WHERE c.id = :id
        SQL;

        return $this->_em->getConnection()
            ->createQueryBuilder()
            ->select('EXISTS(' . $subSql . ')')
            ->setParameter('id', $id)
            ->fetchOne() == 1;
    }

    public function existsTranslationLocaleBy(int $categoryId, string $locale): bool
    {
        $subSql = <<<SQL
            SELECT 1 FROM tbl_category_translation t
            WHERE t.category_id = :cid AND t.locale = :locale
        SQL;

        $connection = $this->_em->getConnection();

        return $connection->createQueryBuilder()
                    ->select('EXISTS(' . $subSql . ')')
                    ->setParameters([
                        'cid' => $categoryId,
                        'locale' => $locale,
                    ])
                    ->execute()
                    ->fetchOne() == 1;
    }
}