<?php

require __DIR__.'/../lib/user.php';

function signup($c, $options)
{
	$pseudo = testInput($_POST['pseudo']);
	$password = testInput($_POST['password']);
	$email = testInput($_POST['email']);

	$response['code'] = 401;
	$response['flash'] = "Bad password or login";
	if ($pseudo && $password && $email)
	{
		$userManager = $c->user;
		if (testPassword($password) && $userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email))
		{
			$c->mail->sendValidationMail($userManager->getUser($pseudo));
			if (isset($_SESSION['flash']['success']))
			{
				$response['code'] = 200;
				$response['flash'] = $_SESSION['flash']['success'];
			}
			else if (isset($_SESSION['flash']['fail']))
			{
				$response['code'] = 500;
				$response['flash'] = $_SESSION['flash']['fail'];
			}
			unset($_SESSION['flash']);
		}
	} 
	return $response;
}
