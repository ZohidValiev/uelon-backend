<?php
namespace App\Context\Common\Infostructure\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Context\Common\Application\Command\User\Signup as AppSignup;
use App\Context\Common\Application\Command\User\Activate as AppActivate;
use App\Context\Common\Application\Command\User\UpdateNickname as AppUpdateNickname;
use App\Context\Common\Application\Command\User\UpdateStatus as AppUpdateStatus;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;
use App\Util\EventDispatcher\EventDispatcherInterface;
use App\Util\PasswordEncoder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private Manager $_em,
        private PasswordEncoder $_passwordEncoder,
        private UserRepositoryInterface $_repository,
        private EventDispatcherInterface $_eventDispatcher,
    )
    {}

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof AppSignup\Command
            || $data instanceof AppUpdateNickname\Command
            || ($data instanceof User && isset($context['item_operation_name']));
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        try {
            if ($data instanceof AppSignup\Command) {
                return $this->_signup($data);
            }
    
            if ($context['item_operation_name'] === 'activate') {
                return $this->_activate($data);
            }

            if ($data instanceof AppUpdateNickname\Command) {
                return $this->_updateNickname($data);
            }

            if ($data instanceof AppUpdateStatus\Command) {
                return $this->_updateStatus($data);
            }
        } catch (NotFoundDomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (\Throwable $e) {
            throw $e; 
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {

    }

    private function _updateStatus(AppUpdateStatus\Command $command): User
    {
        return (new AppUpdateStatus\Handler(
            $this->_em, 
            $this->_repository
        ))->handle($command);
    }

    private function _updateNickname(AppUpdateNickname\Command $command): User
    {
        return (new AppUpdateNickname\Handler(
            $this->_em, 
            $this->_repository
        ))->handle($command);
    }

    private function _signup(AppSignup\Command $command): User
    {
        return (new AppSignup\Handler(
            $this->_em, 
            $this->_passwordEncoder,
            $this->_eventDispatcher
        ))->handle($command);
    }

    private function _activate(User $user): User
    {
        return (new AppActivate\Handler($this->_em))->handle($user);
    }
}