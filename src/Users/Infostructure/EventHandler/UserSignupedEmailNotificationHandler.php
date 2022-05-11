<?php
namespace App\Users\Infostructure\EventHandler;

use App\Shared\Domain\Event\EventHandlerInterface;
use App\Users\Domain\Event\UserSignupedDomainEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Throwable;

class UserSignupedEmailNotificationHandler implements EventHandlerInterface
{
    public function __construct(
        private MailerInterface $_mailer,
        private LoggerInterface $_logger,
        private string $noreplyEmail
    )
    {}

    public function __invoke(UserSignupedDomainEvent $event): void
    {
        $email = (new TemplatedEmail())
            ->subject('Активация аккаунта на uelon.uz')
            ->sender($this->noreplyEmail)
            ->from($this->noreplyEmail)
            ->to($event->email)
            ->htmlTemplate('@users.email/signup.html.twig')
            ->context([
                "event" => $event,
            ]);

        try {
            $this->_mailer->send($email);
        } catch (Throwable $e) {
            $this->_logger->error("A signup message sending exception for email = {$event->email}.");
        }
    }
}