<?php

namespace App\Library\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MyPHPMailer implements MailInterface
{
    /** @var PHPMailer */
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->isSendmail();
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
    }

    public function setFrom(string $mail, string $name): MailInterface
    {
        $this->mail->setFrom($mail, $name);

        return $this;
    }

    public function setSubject(string $subject): MailInterface
    {
        $this->mail->Subject = $subject;

        return $this;
    }

    public function addTo(string $email, string $name): MailInterface
    {
        $this->mail->addAddress($email, $name);

        return $this;
    }

    public function setReplyTo(string $email, string $name): MailInterface
    {
        $this->mail->addReplyTo($email, $name);

        return $this;
    }

    public function addContent(string $type, string $message): MailInterface
    {
        $this->mail->Body = $message;
        switch ($type) {
            case self::TYPE_HTML:
                $this->mail->isHTML(false);

                return $this;
            case self::TYPE_TEXT:
            default:
                $this->mail->isHTML(false);

                return $this;
        }
    }

    public function addAttachment(string $file): MailInterface
    {
        $this->mail->addAttachment($file);

        return $this;
    }

    public function send(string $replyTo = '', string $name = self::OWNER): bool
    {
        if ('' === $replyTo && !empty($_ENV['MAIL'])) {
            $replyTo = $_ENV['MAIL'];
        }
        $this->mail->addReplyTo($replyTo, $name);
        $this->mail->setFrom($replyTo, $name);

        try {
            $this->mail->send();

            return true;
        } catch (Exception $error) {
            throw new \App\Library\Exception($error->getMessage());
        }
    }
}
