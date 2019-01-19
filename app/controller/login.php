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
			echo "Welcome back ".$pseudo;
			return ;
		}
	}
	header("HTTP/1.1 401 Bad Request");
	echo "Bad password or login";
}
