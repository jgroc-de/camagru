<?php

namespace App\Library\Mail;

interface MailInterface
{
    const TYPE_TEXT = 'text/plain';
    const TYPE_HTML = 'text/html';
    const OWNER = 'Camagru webmasta';
    const MAIL = 'lol@lol.fr';

    public function setFrom(string $email, string $name): MailInterface;

    public function setSubject(string $subject): MailInterface;

    public function addTo(string $email, string $name): MailInterface;

    public function setReplyTo(string $email, string $name): MailInterface;

    public function addContent(string $type, string $message): MailInterface;

    public function addAttachment(string $file): MailInterface;

    public function send(string $replyTo = '', string $name = self::OWNER): bool;
}
