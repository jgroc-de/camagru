<?php

require __DIR__.'/../lib/user.php';

function signup($c, $options)
{
	$pseudo = testInput($_POST['pseudo']);
	$password = testInput($_POST['password']);
	$email = testInput($_POST['email']);
	if ($pseudo && $password && $email)
	{
		$userManager = $c->user;
		if (testPassword($password) && $userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email))
		{
			$c->mail->sendValidationMail($userManager->getUser($pseudo));
			if (isset($_SESSION['flash']['success']))
			{
				echo $_SESSION['flash']['success'];
			}
			else if (isset($_SESSION['flash']['fail']))
			{
				header("HTTP/1.1 500 Server Error");
				echo $_SESSION['flash']['fail'];
			}
			unset($_SESSION['flash']);
		}
		return ;
	} 
	header("HTTP/1.1 401 Bad Request");
	echo "Bad password or login";
}
