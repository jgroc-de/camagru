<?php

function reinitPost($c, $options)
{
    $userManager = $c->user;
    $pseudo = $_POST['pseudo'];

    if ($userManager->resetValidkey($pseudo))
    {
        $c->mail->sendReinitMail($userManager->getUser($pseudo));
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
