<?php

require __DIR__.'/../lib/user.php';

function signup($c, $options)
{
    $options['signup'] = true;

    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $pseudo = testInput($_POST['pseudo']);
        $passwd = testInput($_POST['passwd']);
        $email = testInput($_POST['email']);
        if ($pseudo && $passwd && $email)
        {
	        $userManager = $c->user;
            if (testPassword($passwd) && $userManager->addUser($pseudo, password_hash($passwd, PASSWORD_DEFAULT), $email))
            {
                $c->mail->sendValidationMail($userManager->getUser($pseudo));
            }
        } 
        else
            $_SESSION['flash'] = ['fail' => "Données corrompues"];
    }
	$view = 'Sign UP';
	$main = '/signupView.html';
	require __DIR__.'/../view/template.php';
}
