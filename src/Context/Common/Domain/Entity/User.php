<?php
namespace App\Context\Common\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Context\Common\Infostructure\Repository\UserRepository")
 * @ORM\Table(name="tbl_user")
 * @ORM\HasLifecycleCallbacks
 */
#[ApiResource(
    attributes: [
        'pagination_items_per_page' => 20,
    ],
    collectionOperations: [
        'signup' => [
            'method' => 'post',
            'path'   => 'user/signup',
            'input'  => 'App\Context\Common\Infostructure\Dto\SignupDto',
        ],
        'get',
    ],
    itemOperations: [
        'get',
        'activate' => [
            'method' => 'patch',
            'path'   => 'users/{id}/activate/{token}',
            'requirements' => [
                'id' => '\d+',
                'token' => '\w+',
            ],
            'openapi_context' => [
                'parameters' => [
                    [
                        'name' => 'token',
                        'in' => 'path',
                        'description' => 'Token',
                        'schema' => [
                            'type' => 'string',
                        ]
                    ],
                ],
                'requestBody' => [
                    'required' => false,
                    'content' => [
                        'application/merge-patch+json' => [
                            'schema' => [
                                'type' => 'object'
                            ]
                        ],
                    ],
                ]
            ],
        ],
        'updateNickname' => [
            'method' => 'patch',
            'path'   => 'users/{id}/nickname',
            'input'  => 'App\Context\Common\Infostructure\Dto\UserFieldDto',
            'read'   => false,
        ],
        'updateStatus' => [
            'method' => 'patch',
            'path'   => 'users/{id}/status',
            'input'  => 'App\Context\Common\Infostructure\Dto\UserFieldDto',
            'read'   => false,
        ],
    ],
    normalizationContext: [
        'groups' => ['u:read'],
    ]
)]
#[ApiFilter(
    OrderFilter::class,
    properties: ['id' => 'DESC'],
)]
class User implements UserInterface
{
    public const ROLE_USER  = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const STATUS_DELETED  = 0;
    public const STATUS_INACTIVE = 1;
    public const STATUS_ACTIVE   = 2;
    public const STATUS_BLOCKED  = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", columnDefinition="INT UNSIGNED NOT NULL AUTO_INCREMENT")
     */
    #[Groups(['u:read'])]
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    #[Groups(['u:read'])]
    private string $nickname;
    
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    // private UserEmail $email;
    #[Groups(['u:read'])]
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="token", nullable=true)
     */
    private ?Token $activationToken;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['u:read'])]
    private int $status;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(['u:read'])]
    private array $roles = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['u:read'])]
    private DateTimeImmutable $createTime;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['u:read'])]
    private DateTimeImmutable $updateTime;


    public function __construct(UserEmail $email, array $roles, Token $activationToken)
    {
        $this->nickname = $email->getNickname();
        $this->email    = $email->getValue();
        $this->roles    = $roles;
        $this->status   = self::STATUS_INACTIVE;
        $this->activationToken = $activationToken;
    }

    public static function getRolesUser(): array
    {
        return [self::ROLE_USER];
    }

    public static function getRolesAdmin(): array
    {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
        ];
    }

    /**
     * @ORM\PrePersist
     */
    public function prePost(): void
    {
        $this->createTime = $this->updateTime = new \DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->updateTime = new \DateTimeImmutable();
    }

    public function getId():?int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getEmail(): string
    {
        // return $this->email->getValue();
        return $this->email;
    }
   
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_GUEST';
        //$roles[] = 'ROLE_ADMIN';

        return \array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getActivationToken(): Token
    {
        return $this->activationToken;
    }

    public function setStatus(int $status)
    {
        $statuses = [
            self::STATUS_DELETED, 
            self::STATUS_INACTIVE,
            self::STATUS_ACTIVE,
            self::STATUS_BLOCKED,       
        ];

        if (!\in_array($status, $statuses)) {
            throw new \DomainException("Неподдерживаемый статус.");
        }

        $this->status = $status;

        return $this;
    }

    public function isRoleAdmin(): bool
    {
        return \in_array(self::ROLE_ADMIN, $this->getRoles());
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setAsActive(): void
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function setAsBlocked(): void
    {
        $this->status = self::STATUS_BLOCKED;
    }

    public function isDeleted(): bool
    {
        return $this->status === self::STATUS_DELETED;
    }

    public function setAsDeleted(): void
    {
        $this->status = self::STATUS_DELETED;
    }

    public function getSalt()
    {}

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {}

    public function getCreateTime(): \DateTimeImmutable
    {
        return $this->createTime;
    }

    #[Groups(['u:read'])]
    public function createTimeFormated() 
    {
        return $this->createTime->format("d.m.Y H:i");
    }

    public function getUpdateTime(): \DateTimeImmutable
    {
        return $this->updateTime;
    }

    public function activate(): void
    {
        if (!$this->isInactive()) {
            throw new \DomainException('A user status must be inactive.');
        }

        if ($this->activationToken=== null) {
            throw new \DomainException('Token is null.');
        }

        if ($this->activationToken->isExpired()) {
            throw new \DomainException('Token has been expired.');
        }

        $this->activationToken = null;
        $this->setAsActive();
    }
}