<?php
namespace App\Context\Common\Infostructure\Email\Signup;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Throwable;

class MessageSender
{
    public function __construct(
        private MailerInterface $_mailer,
        private LoggerInterface $_logger,
    )
    {}

    public function send(Message $message): void
    {
        $adminEmail = "admin@uelon.uz";
        $email = (new TemplatedEmail())
            ->subject('Активация аккаунта на uelon.uz')
            ->sender($adminEmail)
            ->from($adminEmail)
            ->to($message->getEmail())
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'entityId' => $message->getId(),
                'token' => $message->getToken(),
                'expireTime' => $message->getTokenExpireTime(),
            ]);

        try {
            $this->_mailer->send($email);
        } catch (Throwable $e) {
            $this->_logger->error('Signup email sending exception');
        }
    }
}