<?php

require_once __DIR__.'/../lib/user.php';

function settings($c, $options)
{
    $options['settings'] = true;
    $userManager = $c->user;

    if (isset($_POST['pseudo'], $_POST['password'], $_POST['email']))
    {
        $pseudo = testInput($_POST['pseudo']);
        $password = testInput($_POST['password']);
        $email = testInput($_POST['email']);
        if (testPassword($password) && !empty($pseudo) && !empty($email))
        {
            $alert = (isset($_POST['alert'])) ? true : false;
            if ($userManager->updateUser($pseudo, $password, $email, $alert))
            {
                logUser($userManager->getUserById($_SESSION['id']));
            }
        }
		elseif (!$_SESSION['flash'])
		{
			header("HTTP/1.1 401 Bad Request");
			$_SESSION['flash'] = 'soucis…';
		}
    }
	$user = $userManager->getUser($_SESSION['pseudo']);
}
