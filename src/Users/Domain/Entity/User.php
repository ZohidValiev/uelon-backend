<?php
namespace App\Users\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Entity\Token;
use App\Shared\Domain\Exception\TokenDomainException;
use App\Shared\Domain\Security\AuthUserInterface;
use App\Users\Domain\Service\PasswordHasherInterface;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Users\Infostructure\Repository\UserRepository")
 * @ORM\Table(name="tbl_user")
 * @ORM\HasLifecycleCallbacks
 */
#[ApiResource(
    attributes: [
        'pagination_items_per_page' => 20
    ],
    collectionOperations: [
        'signup' => [
            'security' => 'is_granted("USER_SIGNUP", object)',
            'method' => 'post',
            'path'   => 'users/signup',
            'input'  => 'App\Users\Infostructure\Dto\SignupDto',
            'output'  => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
        ],
        'get' => [
            'normalization_context' => [
                'groups' => ['user:read'],
            ],
        ],
        'create' => [
            'security' => 'is_granted("USER_CREATE", object)',
            'method' => 'post',
            'path'   => 'users',
            'input'  => 'App\Users\Infostructure\Dto\UserCreateDto',
            'output'  => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
        ],
    ],
    itemOperations: [
        'get' => [
            'security' => 'is_granted("USER_GET", object)',
            'normalization_context' => [
                'groups' => ['user:read'],
            ],
        ],
        'activate' => [
            'security' => 'is_granted("USER_ACTIVATE", object)',
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
            'input'  => 'App\Users\Infostructure\Dto\UserActivateDto',
            'output'  => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
            'read' => false,
        ],
        'changeActivationToken' => [
            'security' => 'is_granted("USER_CHANGE_ACTIVATION_TOKEN", object)',
            'method' => 'patch',
            'path'   => 'users/{id}/activation-token',
            'input'  => 'App\Users\Infostructure\Dto\ChangeActivationTokenDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
            'read' => false,
        ],
        'changePassword' => [
            'security' => 'is_granted("USER_CHANGE_PASSWORD", object)',
            'method' => 'patch',
            'path'   => 'users/{id}/password',
            'input'  => 'App\Users\Infostructure\Dto\UserChangePasswordDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
        ],
        'updateNickname' => [
            'security' => 'is_granted("USER_UPDATE_NICKNAME", object)',
            'method' => 'patch',
            'path'   => 'users/{id}/nickname',
            'input'  => 'App\Users\Infostructure\Dto\UserUpdateNicknameDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
            'denormalization_context' => [
                'groups' => ['user:write'],
            ],
        ],
        'updateStatus' => [
            'security' => 'is_granted("USER_UPDATE_STATUS", object)',
            'method' => 'patch',
            'path'   => 'users/{id}/status',
            'input'  => 'App\Users\Infostructure\Dto\UserUpdateStatusDto',
            'output'  => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
            'read'   => false,
            'denormalization_context' => [
                'groups' => ['user:write'],
            ],
        ],
        'updateRole' => [
            'security' => 'is_granted("USER_UPDATE_ROLE", object)',
            'method' => 'patch',
            'path'   => 'users/{id}/role',
            'input'  => 'App\Users\Infostructure\Dto\UserUpdateRoleDto',
            'output' => 'App\Shared\Application\Dto\IdDto',
            'messenger' => 'input',
            'read'   => false,
            'denormalization_context' => [
                'groups' => ['user:write'],
            ],
        ],
        'delete' => [
            'security' => 'is_granted("USER_DELETE", object)',
            'output' => false,
            'messenger' => true,
        ],
    ],
)]
class User implements EntityIDInterface, AuthUserInterface
{
    public const ROLE_GUEST = 'ROLE_USER';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_MODERATOR = 'ROLE_MODERATOR';
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
    #[Groups(['user:read'])]
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[Groups(['user:read'])]
    private string $nickname;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    // private UserEmail $email;
    #[Groups(['user:read'])]
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
    #[Groups(['user:read'])]
    private int $status;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['user:read'])]
    private DateTimeImmutable $createTime;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['user:read'])]
    private DateTimeImmutable $updateTime;


    public static function getRolesUser(): array
    {
        return [self::ROLE_USER];
    }

    public static function getRolesAdmin(): array
    {
        return [
            self::ROLE_USER,
            self::ROLE_MODERATOR,
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

    public function getId(): ?int
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
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
   
    public function getRoles(): array
    {
        return \array_values(\array_unique([self::ROLE_GUEST, ...$this->roles]));
    }

    public function setRole(string $role): self
    {
        if ($role === self::ROLE_ADMIN) {
            $this->roles = [
                self::ROLE_USER,
                self::ROLE_MODERATOR,
                self::ROLE_ADMIN,
            ];
            return $this;
        }
        
        if ($role === self::ROLE_MODERATOR) {
            $this->roles = [
                self::ROLE_USER,
                self::ROLE_MODERATOR,
            ];
            return $this;
        }
        
        if ($role === self::ROLE_USER) {
            $this->roles = [
                self::ROLE_USER,
            ];
            return $this;
        }

        throw new DomainException("The role `{$role}` is incorrect.");
    }

    public function setRoleAsUser(): self
    {
        return $this->setRole(self::ROLE_USER);
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(PasswordHasherInterface $passwordHasher, string $plainPassword): self
    {
        $this->password = $passwordHasher->hashPassword($this, $plainPassword);
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $statuses = [
            self::STATUS_DELETED, 
            self::STATUS_INACTIVE,
            self::STATUS_ACTIVE,
            self::STATUS_BLOCKED,       
        ];

        if (!in_array($status, $statuses)) {
            throw new DomainException("The status `$status` is incorrect.");
        }

        $this->status = $status;

        return $this;
    }

    public function setStatusAsInactive(): self
    {
        return $this->setStatus(self::STATUS_INACTIVE);
    }

    public function getActivationToken(): Token
    {
        return $this->activationToken;
    }

    // private function setActivationToken(?Token $token): self
    // {
    //     $this->activationToken = $token;
    //     return $this;
    // }

    // public function isRoleAdmin(): bool
    // {
    //     return \in_array(self::ROLE_ADMIN, $this->getRoles());
    // }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function isDeleted(): bool
    {
        return $this->status === self::STATUS_DELETED;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    
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

    #[Groups(['user:read'])]
    public function getCreateTimeFormated() 
    {
        return $this->createTime->format("d.m.Y H:i");
    }

    public function getUpdateTime(): \DateTimeImmutable
    {
        return $this->updateTime;
    }

    /**
     * Метод активирует пользователя после регистрации
     * @throws DomainException|TokenDomainException
     */
    public function activate(): void
    {
        if ($this->activationToken === null) {
            throw new DomainException('Activation token must be not null.');
        }

        if ($this->activationToken->isExpired()) {
            throw new TokenDomainException('Activation token has been expired.');
        }

        if (!$this->isInactive()) {
            throw new DomainException('A user status must be inactive.');
        }

        $this->activationToken = null;
        $this->setStatus(self::STATUS_ACTIVE);
    }

    /**
     * Метод гнерирует новый токен активации
     * 
     * @throws DomainException
     */
    public function generateActivationToken(): self
    {
        if (!$this->isInactive()) {
            throw new DomainException('A user status must be inactive.');
        }
        
        if ($this->activationToken === null || $this->activationToken->isExpired()) {
            $this->activationToken = Token::generate();
        }

        return $this;
    }
}