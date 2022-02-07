<?php
namespace App\Context\Common\Infostructure\Listener\Signup;

use App\Context\Common\Application\Event\SignupedDomainEvent;
use App\Context\Common\Application\Event\UserEvents;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Infostructure\Email\Signup\Message;
use App\Context\Common\Infostructure\Email\Signup\MessageSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SignupSubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageSender $_sender)
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
        $user = $event->getTarget();
        $message = new Message(
            id: $user->getId(),
            email: $user->getEmail(),
            nickname: $user->getNickname(),
            token: $user->getActivationToken()->getValue(),
            tokenExpireTime: $user->getActivationToken()->getExpireTime(),
        );
        $this->_sender->send($message);
    }
}