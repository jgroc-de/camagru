<?php

function login($c, $options)
{
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $userManager = $c->user;
    if ($userManager->checkLogin($pseudo, $password))
    {
        $user = $userManager->getUser($pseudo);
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['alert'] = $user['alert'];
        $_SESSION['email'] = $user['email'];
        $response['code'] = 200;
        $response['flash'] = 'Welcome back '.$pseudo;
    }
    else
    {
        $response['code'] = 401;
        $response['flash'] = 'Bad password or login';
    }

    return $response;
}
