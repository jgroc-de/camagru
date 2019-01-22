<?php

require_once __DIR__.'/../lib/user.php';

function password($c, $options)
{
    $userManager = $c->user;
	$_SESSION['flash'] = '';
	
    if (isset($_POST['password']))
    {
        $password = testInput($_POST['password']);
        if (testPassword($password))
        {
			$userManager->updatePassword($password);
			$_SESSION['flash'] = 'Password Succesfully updated';
		}
		else
		{
			header("HTTP/1.1 401 Bad Request");
            $_SESSION['flash'] = 'Bad password!';
		}
    }
	else
		header("HTTP/1.1 401 Bad Request");
	echo $_SESSION['flash'];
	unset($_SESSION['flash']);
}
