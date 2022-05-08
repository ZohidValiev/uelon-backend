<?php
namespace App\Users\Infostructure\Subscriber\Message\Signup;

use App\Users\Domain\Event\SignupedDomainEvent;
use App\Users\Domain\Event\UserEvents;
use App\Users\Domain\Entity\User;
use App\Users\Application\Message\Signup\Message;
use App\Users\Application\Message\Signup\Handler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SignupSubscriber implements EventSubscriberInterface
{
    public function __construct(private Handler $_messageHandler)
    {}

    public static function getSubscribedEvents()
    {
        return [
            UserEvents::EVENT_USER_SIGNUPED => ['onSignuped'],
        ];
    }

    public function onSignuped(SignupedDomainEvent $event)
    {
        /**
         * @var User $user
         */
        $user    = $event->getTarget();
        $message = new Message(
            email: $user->getEmail(),
            nickname: $user->getNickname(),
            token: $user->getActivationToken()->getValue(),
            tokenExpireTime: $user->getActivationToken()->getExpireTime(),
        );

        $messageHandler = $this->_messageHandler;
        $messageHandler($message);
    }
}