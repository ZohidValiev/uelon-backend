<?php
declare(strict_types=1);

namespace App\Test\Users\Application\Command\User\Signup;

use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Users\Application\Command\User\Signup\Command;
use App\Users\Application\Command\User\Signup\Handler;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
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

    public function dataProvider(): array
    {
        $email = 'user@email.com';
        $password = '1234567';

        return [
            [$email, $password],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testUserSignupSuccess(string $email, string $password): void
    {
        $this->_eventDispatcherMock
            ->expects($this->exactly(2))
            ->method('dispatch')
        ;

        /**
         * @var EventDispatcherInterface $eventDispatcherMock
         */
        $eventDispatcherMock = $this->_eventDispatcherMock;
        $userSignupCommand = new Command($email, $password);
        $userSignupHandler = new Handler(
            $this->_repository,
            $eventDispatcherMock,
            $this->_userFactory,
        );
        $userId = $userSignupHandler($userSignupCommand);

        $this->assertGreaterThan(0, $userId);

        $user = $this->_repository->getById($userId);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userSignupCommand->email, $user->getEmail());
        $this->assertContainsEquals(User::ROLE_USER, $user->getRoles());
        $this->assertEquals(User::STATUS_INACTIVE, $user->getStatus());
    }
}