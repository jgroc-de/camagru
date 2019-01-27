<?php

function logout()
{
    $response['code'] = 200;
    $response['flash'] = 'Cya '.$_SESSION['pseudo'].'!';
    session_unset();
    session_destroy();
    return $response;
}
