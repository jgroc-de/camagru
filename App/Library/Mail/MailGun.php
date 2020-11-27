<?php

namespace App\Library\Mail;

use Mailgun\Mailgun as Mail;

class MailGun implements MailInterface
{
    /** @var Mail */
    private $mail;

    /** @var string */
    private $from;

    /** @var string */
    private $subject;

    /** @var array */
    private $to;

    /** @var string */
    private $content;

    /** @var array */
    private $replyTo;

    /** @var string */
    private $attachment;

    /** @var string */
    private $type;

    public function __construct()
    {
        $this->mail = Mail::create($_ENV['MAILGUN_API_KEY'], 'https://api.eu.mailgun.net');
    }

    public function setFrom(string $email, string $name): MailInterface
    {
        $this->from = "$name <$email>";

        return $this;
    }

    public function setSubject(string $subject): MailInterface
    {
        $this->subject = $subject;

        return $this;
    }

    public function addTo(string $email, string $name): MailInterface
    {
        $this->to[] = "$name <$email>";
        //$this->to[] = $email;

        return $this;
    }

    public function setReplyTo(string $email, string $name): MailInterface
    {
        $this->replyTo[] = "$name <$email>";

        return $this;
    }

    public function addContent(string $type, string $message): MailInterface
    {
        $this->content = $message;
        $this->type = 'text';

        return $this;
    }

    public function addAttachment(string $file): MailInterface
    {
        $this->attachment = $file;

        return $this;
    }

    public function send(string $replyTo = '', string $name = self::OWNER): bool
    {


        $adminMail = $_ENV['MAIL'] ?? MailInterface::MAIL;
        if ('' === $replyTo && !empty($_ENV['MAIL'])) {
            $replyTo = $_ENV['MAIL'];
        }
        $this->setFrom($adminMail, MailInterface::OWNER);
        $this->setReplyTo($replyTo, $name);
        $mail = Mail::create($_ENV['MAILGUN_API_KEY'], 'https://api.eu.mailgun.net');

        try {
            $data = [
                'from'    => $this->from,
                'to'      => $this->to,
                'subject' => $this->subject,
            ];
            if ($this->content) {
                $data[$this->type] = $this->content;
            }
            $response = $mail->messages()->send('camagru42.herokuapp.com', $data);

            return true;
        } catch (\Exception $e) {
            echo 'Caught exception: '.$e->getMessage()."\n";

            return false;
        }
    }
}
