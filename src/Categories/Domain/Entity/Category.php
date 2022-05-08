<?php
namespace App\Categories\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Exception\NotFoundDomainException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Categories\Infostructure\Repository\CategoryRepository")
 * @ORM\Table(name="tbl_category")
 */
 #[ApiResource(
    attributes: [
        'pagination_enabled' => false,
    ],
    collectionOperations: [
        'roots' => [
            'method' => 'get',
            'path'   => '/categories',
            'normalization_context' => [
                'groups' => [
                    'category:read',
                    'translation:read',
                ],
            ],
        ],
        'children' => [
            'method' => 'get',
            'path'   => '/categories/{id}/children',
            'requirements' => [
                'id' => '\d+'
            ],
            'openapi_context' => [
                'parameters' => [
                    [
                        'name' => 'id',
                        'in' => 'path',
                        'description' => 'Parent category id',
                        'schema' => [
                            'type' => 'integer'
                        ]
                    ]
                ]
            ],
            'normalization_context' => [
                'groups' => [
                    'category:read',
                    'translation:read',
                ],
            ],
        ],
        'create' => [
            'security' => 'is_granted("CATEGORY_CREATE", object)',
            'method' => 'post',
            'input'  => 'App\Categories\Infostructure\Dto\CategoryCreateDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
        ],
    ],
    itemOperations: [
        'get' => [
            'security' => 'is_granted("CATEGORY_GET", object)',
            'method' => 'get',
            'normalization_context' => [
                'groups' => [
                    'category:read',
                    'translation:read',
                ],
            ],
        ],
        'changePosition' => [
            'security' => 'is_granted("CATEGORY_CHANGE_POSITION", object)',
            'method' => 'patch',
            'path'   => '/categories/{id}/position',
            'input'  => 'App\Categories\Infostructure\Dto\CategoryChangePositionDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'read'   => false,
            'requirements' => [
                'id' => '\d+',
            ],
            'openapi_context' => [
                'parameters' => [
                    [
                        'name' => 'id',
                        'in' => 'path',
                        'description' => 'Category id',
                        'schema' => [
                            'type' => 'integer'
                        ]
                    ],
                ],
            ],
            'messenger' => 'input',
            'denormalization_context' => [
                'groups' => ['category:write'],
            ],
        ],
        'update' => [
            'security' => 'is_granted("CATEGORY_UPDATE", object)',
            'method' => 'patch',
            'input'  => 'App\Categories\Infostructure\Dto\CategoryUpdateDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'read'   => false,
            'messenger' => 'input',
            'denormalization_context' => [
                'groups' => ['category:write'],
            ],
        ],
        'delete' => [
            'security' => 'is_granted("CATEGORY_DELETE", object)',
            'output' => false,
            'messenger' => true,
        ],
    ],
 )]
class Category implements EntityIDInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['category:read'])]
    private ?int $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    #[Groups(['category:read'])]
    private int $level = 1;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    #[Groups(['category:read'])]
    private bool $isActive = true;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    #[Groups(['category:read'])]
    private bool $hasChildren = false;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['category:read'])]
    private int $position;

    /**
     * @ORM\Column(type="string", length=50, options={"default": ""})
     */
    #[Groups(['category:read'])]
    private string $icon;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     */
    #[ApiProperty(
        readableLink: false,
        writableLink: false,
    )]
    #[Groups(['category:read'])]
    private ?Category $parent = null;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Category", 
     *      mappedBy="parent",
     *      orphanRemoval=true
     * )
     * @ORM\OrderBy({"position"="ASC"})
     */
    private Collection $children;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "CategoryTranslation", 
     *      mappedBy = "category", 
     *      cascade = {"persist"},
     *      orphanRemoval = true,
     *      indexBy = "locale"
     * )
     */
    #[Groups(['category:read'])]
    private Collection $translations;

    /**
     * @ORM\OneToMany(
     *      targetEntity="CategoryRelation", 
     *      mappedBy="parent",
     *      cascade={"persist"}
     * )
     */
    private Collection $relations;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['c:read'])]
    public function getTitle(string $locale = "RU"): string
    {
        return $this->translations[$locale]->getTitle();
    }
   
    public function getHasChildren(): bool
    {
        return $this->hasChildren;
    }

    public function setHasChildren(bool $hasChildren): self
    {
        $this->hasChildren = $hasChildren;
        return $this;
    }

    public function getChildren(): array
    {
        return $this->children->getValues();
    }

    public function removeChild(Category $child): bool
    {
        if ($this->children->removeElement($child)) {
            $child->setParent(null);
            $this->hasChildren = !$this->children->isEmpty();
            return true;
        }

        return false;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function positionUp(): void
    {
        if ($this->position === 1) {
            throw new \DomainException("Cannot increase position");
        }

        $this->position -= 1;
    }

    public function positionDown(): void
    {
        $this->position += 1;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getIcon(): string 
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations->toArray();
    }

    public function getTranslation(string $locale): ?CategoryTranslation
    {
        /**
         * @var CategoryTranslation $translation
         */
        foreach ($this->translations as $translation) 
        {
            if ($translation->getLocale() === $locale) {
                return $translation;
            }
        }

        return null;
    }

    public function addTranslation(string $locale, string $title): CategoryTranslation
    {
        $translation = new CategoryTranslation($this, $locale, $title);

        $this->translations[$locale] = $translation;

        return $translation;
    }

    public function removeTranslation(CategoryTranslation $translation): bool
    {
        if ($this->translations->removeElement($translation)) {
            $translation->setCategory(null);
            return true;
        }

        return false;
    }

    /**
     * @throws NotFoundDomainException
     */
    public function updateTranslation(string $locale, string $title): CategoryTranslation
    {
        $translation = $this->getTranslation($locale);

        NotFoundDomainException::notNull($translation, "Category translation by locale = $locale has not been found");

        $translation->setTitle($title);

        return $translation;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): static
    {
        $this->parent = $parent;

        if ($parent != null) {
            $this->level  = $parent->level + 1;
            $parent->hasChildren = true;
        }

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getIsActive(): bool
    {
        return $this->isActive();
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function addRelation(self $ancestor): self
    {
        $relation = new CategoryRelation($ancestor, $this);
        $this->relations[] = $relation;
        return $this;
    }
}