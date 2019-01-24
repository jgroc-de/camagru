<?php

require_once __DIR__.'/../lib/user.php';

function password($c, $options)
{
    $userManager = $c->user;
	
	$response['code'] = 401;
    if (isset($_POST['password']))
    {
        $password = testInput($_POST['password']);
        if (testPassword($password))
        {
			$userManager->updatePassword($password);
			$response['code'] = 200;
			$response['flash'] = 'Password Succesfully updated';
		}
		else
		{
			$response['flash'] = 'Bad password!';
		}
    }
	return $response;
}
