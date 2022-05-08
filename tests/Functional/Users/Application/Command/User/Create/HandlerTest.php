<?php
declare(strict_types=1);

namespace App\Test\Users\Application\Command\User\Create;

use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Users\Application\Command\User\Create\Command;
use App\Users\Application\Command\User\Create\Handler;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use DomainException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandlerTest extends KernelTestCase
{
    private UserRepositoryInterface $_repository;
    private UserFactory $_userFactory;
    private MockObject $_eventDispatcherMock;

    protected function setUp(): void
    {
        static::bootKernel();

        $container = static::getContainer();
        $this->_repository = $container->get(UserRepositoryInterface::class);
        $this->_userFactory = $container->get(UserFactory::class);
        $this->_eventDispatcherMock = $this->getMockForAbstractClass(EventDispatcherInterface::class);
    }

    public function correctDataProvider(): array
    {
        $email = 'user@email.com';
        $nickname = 'User';
        $password = '1234567';
        $role = User::ROLE_USER;
        $status = User::STATUS_ACTIVE;

        return [
            // Success data
            [$email, $nickname, $password, $role, $status, true],
            [$email, $nickname, $password, $role, $status, false],
        ];
    }

    /**
     * @dataProvider correctDataProvider
     */
    public function testUserCreateSuccess(
        string $email,
        string $nickname,
        string $password,
        string $role,
        int $status,
        bool $useVerification,
    ): void
    {
        $this->_eventDispatcherMock
            ->expects($this->exactly($useVerification ? 2 : 0))
            ->method('dispatch')
        ;

        $userCreateCommand = new Command(
            email: $email,
            nickname: $nickname,
            password: $password,
            role: $role,
            status: $status,
            sendNotification: $useVerification,
        );

        /**
         * @var EventDispatcherInterface $eventDispatcherMock
         */
        $eventDispatcherMock = $this->_eventDispatcherMock;
        $userCreateHandler = new Handler(
            $this->_repository,
            $eventDispatcherMock,
            $this->_userFactory,
        );
        $userId = $userCreateHandler($userCreateCommand);

        $this->assertGreaterThan(0, $userId);

        $user = $this->_repository->getById($userId);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userCreateCommand->email, $user->getEmail());
        $this->assertEquals($userCreateCommand->nickname, $user->getNickname());
        $this->assertContainsEquals(User::ROLE_USER, $user->getRoles());
        $this->assertEquals($userCreateCommand->status, $user->getStatus());
    }

    public function incorrectDataProvider(): array
    {
        $email = 'user@email.com';
        $nickname = 'User';
        $password = '1234567';
        $role = 'INCORRECT';
        $status = 1000;

        return [
            // Failure data
            [$email, $nickname, $password, User::ROLE_USER, $status, true],
            [$email, $nickname, $password, $role, User::STATUS_ACTIVE, false],
        ];
    }

    /**
     * @dataProvider incorrectDataProvider
     */
    public function testUserCreateFailure(
        string $email,
        string $nickname,
        string $password,
        string $role,
        int $status,
        bool $useVerification,
    ): void
    {
        $this->expectException(DomainException::class);

        $this->_eventDispatcherMock
            ->expects($this->exactly(0))
            ->method('dispatch')
        ;

        $userCreateCommand = new Command(
            email: $email,
            nickname: $nickname,
            password: $password,
            role: $role,
            status: $status,
            sendNotification: $useVerification,
        );

        /**
         * @var EventDispatcherInterface $eventDispatcherMock
         */
        $eventDispatcherMock = $this->_eventDispatcherMock;
        $userCreateHandler = new Handler(
            $this->_repository,
            $eventDispatcherMock,
            $this->_userFactory,
        );
        $userCreateHandler($userCreateCommand);
    }
}