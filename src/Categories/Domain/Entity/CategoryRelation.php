<?php
namespace App\Categories\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use App\Categories\Domain\Entity\Category;

/**
 * @ORM\Entity
 * @ORM\Table(
 *      name = "tbl_category_relation",
 *      indexes = {@ORM\Index( name = "child_id", columns = {"child_id"} )}
 * )
 */
class CategoryRelation
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Category", inversedBy="relations")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    public Category $parent;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Category")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    public Category $child;

    public function __construct(Category $parent, Category $child)
    {
        if ($parent === null) {
            throw new \InvalidArgumentException('Property $parent cannot be empty');
        }
        
        if ($child === null) {
            throw new \InvalidArgumentException('Property $child cannot be empty');
        }
        
        $this->parent = $parent;
        $this->child  = $child;
    }
}