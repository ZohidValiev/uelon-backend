<?php
namespace App\Context\Category\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(
 *      name="tbl_category_translation",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="category_locale", columns={"category_id", "locale"})
 *      }
 * )
 */
#[ApiResource(
    compositeIdentifier: false,
    collectionOperations: [
        // 'create' => [
        //     'method' => 'post',
        //     'path' => '/categories/{categoryId}/translations',
        //     'requirements' => [
        //         'categoryId' => '\d+',
        //     ],
        //     'openapi_context' => [
        //         'parameters' => [
        //             [
        //                 'name' => 'categoryId',
        //                 'in' => 'path',
        //                 'required' => true,
        //                 'description' => 'Category id',
        //                 'schema' => [
        //                     'type' => 'integer',
        //                 ],
        //             ]
        //         ]
        //     ],
        //     'input'  => 'App\Context\Category\Infostructure\Dto\CategoryTranslationCreateDto',
        // ],
    ],
    itemOperations: [
        'get' => [
            'path'   => '/categories/{categoryId}/translations/{locale}',
            'requirements' => [
                'categoryId' => '\d+',
                'locale'     => '\w{2}',
            ],
            'openapi_context' => [
                'parameters' => [
                    [
                        'name' => 'categoryId',
                        'in' => 'path',
                        'required' => true,
                        'description' => 'Category id',
                        'schema' => [
                            'type' => 'integer',
                        ],
                    ],
                    [
                        'name' => 'locale',
                        'in' => 'path',
                        'required' => true,
                        'description' => 'Language locale',
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
        ],
        // 'update' => [
        //     'read' => false,
        //     'method' => 'patch',
        //     'path'   => '/categories/{categoryId}/translations/{locale}',
        //     'requirements' => [
        //         'categoryId' => '\d+',
        //         'locale'     => '\w+',
        //     ],
        //     'openapi_context' => [
        //         'parameters' => [
        //             [
        //                 'name' => 'categoryId',
        //                 'in' => 'path',
        //                 'description' => 'Category Id',
        //                 'schema' => [
        //                     'type' => 'integer'
        //                 ],
        //             ],
        //             [
        //                 'name' => 'locale',
        //                 'in' => 'path',
        //                 'description' => 'Language locale',
        //                 'schema' => [
        //                     'type' => 'string'
        //                 ],
        //             ],
        //         ],
        //     ],
        //     'input' => 'App\Context\Category\Infostructure\Dto\CategoryTranslationUpdateDto',
        // ],
        // 'delete' => [
        //     'method' => 'delete',
        //     'path'   => '/categories/{categoryId}/translations/{locale}',
        //     'requirements' => [
        //         'categoryId' => '\d+',
        //         'locale'     => '\w+',
        //     ],
        //     'openapi_context' => [
        //         'parameters' => [
        //             [
        //                 'name' => 'categoryId',
        //                 'in' => 'path',
        //                 'description' => 'Category Id',
        //                 'schema' => [
        //                     'type' => 'integer'
        //                 ],
        //             ],
        //             [
        //                 'name' => 'locale',
        //                 'in' => 'path',
        //                 'description' => 'Language locale',
        //                 'schema' => [
        //                     'type' => 'string'
        //                 ],
        //             ],
        //         ],
        //     ],
        // ],
    ],
)]
class CategoryTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ApiProperty(identifier: false)]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    #[Groups(['c:read'])]
    private string $title;

    /**
     * @ORM\Column(type="string", length=2, nullable=false)
     */
    #[ApiProperty(identifier: true)]
    #[Groups(['c:read'])]
    private string $locale;

    /**
     * @ORM\ManyToOne(targetEntity = "Category", inversedBy = "translations")
     * @ORM\JoinColumn(
     *      nullable=false,
     *      onDelete="cascade"
     * )
     */
    private ?Category $category;


    public function __construct(Category $category, string $locale, string $title)
    {
        if ($category == null) {
            throw new InvalidArgumentException('Property $category cannot be null');
        }

        if ($locale == null) {
            throw new InvalidArgumentException('Property $locale cannot be null');
        }

        if ($title == null) {
            throw new InvalidArgumentException('Property $title cannot be null');
        }
        
        $this->category = $category;
        $this->locale = $locale;
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    #[ApiProperty(identifier: true)]
    public function getCategoryId(): ?int
    {
        return $this->category?->getId();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }
}