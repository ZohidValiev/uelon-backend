<?php
namespace App\Context\Common\Infostructure\Listener\Signup;

use App\Context\Common\Application\Event\SignupCompletedDomainEvent;
use App\Context\Common\Application\Event\UserEvents;
use App\Context\Common\Infostructure\Email\UserSignupMessageSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SignupSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserSignupMessageSender $_sender)
    {}

    public static function getSubscribedEvents()
    {
        return [
            UserEvents::EVENT_SIGNUP_COMPLETED => ['onSignupCompleted'],
        ];
    }

    public function onSignupCompleted(SignupCompletedDomainEvent $event)
    {
        $param = new Param();
        $param->entityId = $event->getEntityId();
        $param->email    = $event->getEmail();
        $param->token    = $event->getToken();
        $param->tokenExpireTime = $event->getTokenExpireTime();

        $this->_sender->send($param);
    }
}