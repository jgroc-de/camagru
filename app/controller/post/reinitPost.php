<?php

function reinitPost($c, $options)
{
    $userManager = $c->user;
    $pseudo = $_POST['pseudo'];

    $user = $userManager->getUser($pseudo);
    if (!empty($user) && $userManager->resetValidkey($pseudo))
    {
        $c->mail->sendReinitMail($user);
        $response['code'] = 200;
    }
    else
    {
        $response['code'] = 404;
        $response['flash'] = 'Soldat inconnu';
    }
    if (isset($_SESSION['flash']))
    {
        $response['flash'] = $_SESSION['flash'];
    }

    return $response;
}
