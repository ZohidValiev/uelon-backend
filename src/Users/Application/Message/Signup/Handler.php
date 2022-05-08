<?php
namespace App\Users\Application\Message\Signup;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Throwable;

class Handler
{
    public function __construct(
        private MailerInterface $_mailer,
        private LoggerInterface $_logger,
        private string $noreplyEmail
    )
    {}

    public function __invoke(Message $message): void
    {
        $email = (new TemplatedEmail())
            ->subject('Активация аккаунта на uelon.uz')
            ->sender($this->noreplyEmail)
            ->from($this->noreplyEmail)
            ->to($message->email)
            ->htmlTemplate('@users.email/signup.html.twig')
            ->context([
                "message" => $message,
            ]);

        try {
            $this->_mailer->send($email);
        } catch (Throwable $e) {
            $this->_logger->error("A signup message sending exception for email = {$message->email}.");
        }
    }
}