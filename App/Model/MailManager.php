<?php

namespace App\Model;

class MailManager
{
    const URL = 'http://jgroc2s.free.fr';
    const EMAIL = 'jgroc2s@free.fr';

    public function sendMail(string $dest, string $subject, string $message, string $headers): bool
    {
        //$mail = new PHPMailer\PHPMailer\PHPMailer();

        /*$mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.free.fr";
        $mail->SMTPDebug = 0;
        $mail->Port = 25;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->Password = 'secret';/
        $mail->Username = 'lol@camagru.fr';
        $mail->setFrom('lol@camagru.fr', 'jgroc-de');
        $mail->addAddress($dest);
        $mail->Subject = $subject;
        $mail->Body = $message;*/
        return mail($dest, $subject, $message, $headers);
        //return $mail->send();
    }

    public function sendReinitMail(array $user): void
    {
        $key = $user['validkey'];
        $dest = $user['email'];
        $login = $user['pseudo'];
        $subject = 'Camagru Reinitialisation link';
        $message = 'Bonjour '.$login.',

            Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci dessous
            ou copier/coller dans votre navigateur internet (firefox!).

            '.self::URL.'/index.php?action=reinit&log='.urlencode($login).'&key='.urlencode($key).'


            ---------------
            Por favor, ne me spammez pas...';
        $headers = 'From: lol@camagru.fr'."\r\n".'Reply-To: jgroc2s@free.fr'."\r\n".'X-Mailer: PHP/'.phpversion();
        $this->sendMail($dest, $subject, $message, $headers);
        $_SESSION['flash'] = ['success' => 'Opération éffectuée! Scrutez votre boite mail avec attention'];
    }

    public function sendValidationMail(array $user): bool
    {
        $subject = 'Camagru Activation link';
        $message = 'Bienvenue sur Camagru '.$user['pseudo'].',
			 
			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
'.self::URL.'/index.php?action=validation&log='.urlencode($user['pseudo']).'&key='.urlencode($user['validkey']).'
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';

        $headers = 'From: lol@camagru.fr'."\r\n".'Reply-To: jgroc2s@free.fr'."\r\n".'X-Mailer: PHP/'.phpversion();
        if ($this->sendMail($user['email'], $subject, $message, $headers)) {
            $_SESSION['flash'] = ['success' => 'Bienvenu! Un mail vous a été envoyé'];
        } else {
            $_SESSION['flash'] = ['success' => 'Bienvenu! Pas de mail pour vous par contre…'];
        }

        return true;
    }

    public function sendCommentMail(array $user): void
    {
        $subject = 'nouveau commentaire';
        $message = 'Hi '.$user['pseudo'].', You have a new comment for one of your picture! Check-it out';
        $headers = 'From: lol@camagru.fr'."\r\n".'Reply-To: jgroc2s@free.fr'."\r\n".'X-Mailer: PHP/'.phpversion();
        $this->sendMail($user['email'], $subject, $message, $headers);
    }

    public function sendContactMail(): bool
    {
        $headers = 'From: '.$_POST['email']."\r\n".'Reply-To: '.self::EMAIL."\r\n".'X-Mailer: PHP/'.phpversion();
        if ($this->sendMail(self::EMAIL, $_POST['subject'], $_POST['message'], $headers)) {
            $_SESSION['flash'] = ['success' => 'Bienvenu! Un mail vous a été envoyé'];
        } else {
            $_SESSION['flash'] = ['success' => 'Bienvenu! Pas de mail pour vous par contre…'];
        }

        return true;
    }
}
