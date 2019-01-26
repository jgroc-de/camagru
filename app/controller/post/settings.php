<?php

function settings($c, $options)
{
	$userManager = $c->user;

	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	$alert = $_POST['alert'] ? true : false;
	if ($userManager->updateUser($pseudo, $email, $alert))
	{
		$user = $userManager->getUserById($response['id']);
		$_SESSION['pseudo'] = $user['pseudo'];
		$_SESSION['id'] = $user['id'];
		$_SESSION['alert'] = $user['alert'];
		$response['code'] = 200;
		$response['flash'] = 'Profil Succesfully updated';
	}
	else
	{
		$response['code'] = 400;
		$response['flash'] = 'Pseudo unavailable!';
	}
	return $response;
}
