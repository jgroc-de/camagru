<?php

require_once __DIR__.'/../lib/user.php';

function settings($c, $options)
{
    $userManager = $c->user;

	$response['code'] = 401;
    if (isset($_POST['pseudo'], $_POST['email'], $_POST['alert']))
    {
        $pseudo = testInput($_POST['pseudo']);
        $email = testInput($_POST['email']);
        if (!empty($pseudo) && !empty($email))
        {
            $alert = $_POST['alert'] ? true : false;
            if ($userManager->updateUser($pseudo, $email, $alert))
            {
                logUser($userManager->getUserById($response['id']));
				$response['code'] = 200;
				$response['flash'] = 'Profil Succesfully updated';
            }
			else
			{
				$response['code'] = 400;
            	$response['flash'] = 'Pseudo unavailable!';
			}
        }
    }
	return $response;
}
