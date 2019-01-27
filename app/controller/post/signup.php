<?php

function signup($c, $options)
{
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $userManager = $c->user;
    if ($userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email)) {
        $c->mail->sendValidationMail($userManager->getUser($pseudo));
        if (isset($_SESSION['flash']['success'])) {
            $response['code'] = 200;
            $response['flash'] = $_SESSION['flash']['success'];
        } elseif (isset($_SESSION['flash']['fail'])) {
            $response['code'] = 500;
            $response['flash'] = $_SESSION['flash']['fail'];
        }
        unset($_SESSION['flash']);
    } else {
        $response['code'] = 401;
        $response['flash'] = 'Bad password or login';
    }

    return $response;
}
