<?php
namespace App\Users\Infostructure\Subscriber\JWT;

use App\Users\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_SUCCESS => ['onAuthenticationSuccess'],
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        /**
         * @var User $user
         */
        $data["data"] = [
            "id" => $user->getId(),
            "username" => $user->getUserIdentifier(),
            "roles" => $user->getRoles(),
            "nickname" => $user->getNickname(),
        ];

        $event->setData($data);
    }
}