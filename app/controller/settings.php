<?php

require_once __DIR__.'/../lib/user.php';

function settings($c, $options)
{
    $options['settings'] = true;
    $userManager = $c->user;

    if (isset($_POST['pseudo'], $_POST['passwd'], $_POST['email']))
    {
        $pseudo = testInput($_POST['pseudo']);
        $passwd = testInput($_POST['passwd']);
        $email = testInput($_POST['email']);
        if (testPassword($passwd) && !empty($pseudo) && !empty($email))
        {
            $alert = (isset($_POST['alert']))? true:false;
            if ($userManager->updateUser($pseudo, $passwd, $email, $alert))
            {
                logUser($userManager->getUserById($_SESSION['id']));
            }
        }
        elseif (!$_SESSION['flash'])
            $_SESSION['flash'] = 'soucis…';
    }
	$user = $userManager->getUser($_SESSION['pseudo']);
	$view = 'Settings';
	$main = '/settingsView.html';
	require __DIR__.'/../view/template.php';
}
