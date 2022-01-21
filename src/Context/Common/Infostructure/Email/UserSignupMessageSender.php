<?php
namespace App\Context\Common\Infostructure\Email;

use App\Context\Common\Infostructure\Listener\Signup\Param;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class UserSignupMessageSender
{
    public function __construct(
        private MailerInterface $_mailer,
        private LoggerInterface $_logger,
    )
    {}

    public function send(Param $param): void
    {
        $email = (new TemplatedEmail())
            ->subject('Активация аккаунта на uelon.uz')
            ->to($param->email)
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'entityId' => $param->entityId,
                'token' => $param->token,
                'expireTime' => $param->tokenExpireTime,
            ]);

        try {
            $this->_mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->_logger->error('Signup email sending exception');
        }
    }
}