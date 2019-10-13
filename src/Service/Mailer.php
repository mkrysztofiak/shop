<?php


namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendSimpleTextEmail(string $from, string $to, string $subject, string $body)
    {
        $email = new Email();
        $email->from($from);
        $email->to($to);
        $email->subject($subject);
        $email->text($body);

        $this->mailer->send($email);
    }
}