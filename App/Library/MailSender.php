<?php

namespace App\Library;

use App\Library\Mail\MailInterface;

/**
 * managing mail sending
 */
class MailSender
{
    /** @var string */
    private $siteUrl;
    /** @var MailInterface */
    private $mail;
    /** @var FlashMessage */
    private $flash;

    public function __construct(?FlashMessage $flashMessage, MailInterface $mail, string $siteUrl)
    {
        $this->flash = $flashMessage;
        $this->siteUrl = $siteUrl;
        $this->mail = $mail;
    }

    public function send(): bool
    {
        if ($this->mail->send()) {
            $_SESSION['flash'] = ['success' => 'Email sent. Check your mailbox, your spambox, your lunchbox, everything!!!'];
        } else {
            $_SESSION['flash'] = ['fail' => 'Email NOT sent.. For emergency cases, plz, "contact" us!!!'];
        }

        return true;
    }

    public function sendValidationMail(array $user): bool
    {
        $subject = 'Camagru Activation link';
        $message = 'Bienvenue sur Camagru '.$user['pseudo'].',
			 
			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
'.$this->siteUrl.'/index.php?action=validation&log='.urlencode($user['pseudo']).'&key='.urlencode($user['validkey']).'
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';

        $this->mail->addTo($user['email'], $user['pseudo']);
        $this->mail->setSubject($subject);
        $this->mail->addContent(MailInterface::TYPE_TEXT, $message);

        return $this->send();
    }

    public function sendCommentMail(array $user): bool
    {
        $subject = 'nouveau commentaire';
        $message = 'Hi '.$user['pseudo'].', You have a new comment for one of your picture! Check-it out';
        $this->mail->addTo($user['email'], $user['pseudo']);
        $this->mail->setSubject($subject);
        $this->mail->addContent(MailInterface::TYPE_TEXT, $message);

        return $this->send();
    }

    public function sendResetMail(array $user): bool
    {
        $key = $user['validkey'];
        $login = $user['pseudo'];
        $subject = 'Camagru Reinitialisation link';
        $message = 'Bonjour '.$login.',

            Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci dessous
            ou copier/coller dans votre navigateur internet (firefox!).

            '.$this->siteUrl.'/index.php?action=reinit&log='.urlencode($login).'&key='.urlencode($key).'


            ---------------
            Por favor, ne me spammez pas...';
        $_SESSION['flash'] = ['success' => 'Opération éffectuée! Scrutez votre boite mail avec attention'];

        $this->mail->addTo($user['email'], $login);

        $this->mail->setSubject($subject);
        $this->mail->addContent(MailInterface::TYPE_TEXT, $message);

        return $this->send();
    }

    public function sendContactMail(): bool
    {
        $this->mail->addTo($_ENV['MAIL_OWNER'], MailInterface::OWNER);
        $this->mail->setSubject('User contact from ' . $_SERVER['SERVER_NAME']);
        $this->mail->setReplyTo($_POST['email'], $_POST['name']);
        $this->mail->addContent(MailInterface::TYPE_TEXT, "Bonjour maître des 7 océans numériques,

    On vous a laissé ce messsage:

         Sujet: {$_POST['subject']}

         {$_POST['message']}

    Glorieuse journée à vous!

            Votre dévoué, " . $_SERVER['SERVER_NAME']);

        return $this->send();
    }

    private function linkGen(array $user, string $action): string
    {
        return $this->siteUrl . "/validation?action=$action&token=" . rawurlencode($user['token']) . '&id=' . $user['id'];
    }
}
