<?php

require_once __DIR__.'/../lib/user.php';

function settings($c, $options)
{
    $userManager = $c->user;
    $_SESSION['flash'] = '';

    if (isset($_POST['pseudo'], $_POST['email'], $_POST['alert']))
    {
        $pseudo = testInput($_POST['pseudo']);
        $email = testInput($_POST['email']);
        if (!empty($pseudo) && !empty($email))
        {
            $alert = $_POST['alert'] ? true : false;
            if ($userManager->updateUser($pseudo, $email, $alert))
            {
                logUser($userManager->getUserById($_SESSION['id']));
                $_SESSION['flash'] = 'Profil Succesfully updated';
            }
			else
			{
				header("HTTP/1.1 400 Bad Request");
            	$_SESSION['flash'] = 'Pseudo unavailable!';
			}
        }
		else
		{
			header("HTTP/1.1 401 Bad Request");
		}
    }
	else
		header("HTTP/1.1 401 Bad Request");
	echo $_SESSION['flash'];
	unset($_SESSION['flash']);
}
