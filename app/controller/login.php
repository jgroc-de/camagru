<?php

require __DIR__.'/../lib/user.php';

function login($c, $options)
{
	$pseudo = testInput($_POST['pseudo']);
	$password = testInput($_POST['password']);
	if ($pseudo && $password)
	{
		$userManager = $c->user;
		if ($userManager->checkLogin($pseudo, $password))
		{
			logUser($userManager->getUser($pseudo));
			$response['code'] = 200;
			$response['flash'] = "Welcome back ".$pseudo;
			return $response;
		}
	}
	$response['code'] = 401;
	$response['flash'] = "Bad password or login";
	return $response;
}
