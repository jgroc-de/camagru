<?php

function settings($c, $options)
{
    $userManager = $c->user;

    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $alert = isset($_POST['alert']) ? true : false;
    if ($userManager->updateUser($pseudo, $email, $alert))
    {
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['alert'] = $alert;
        $_SESSION['email'] = $email;
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
