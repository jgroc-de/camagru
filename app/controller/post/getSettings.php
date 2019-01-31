<?php

function getSettings($c, $options)
{
    $response['code'] = 200;
    $response['settings'] = [
        'pseudo' => $_SESSION['pseudo'],
        'email' => $_SESSION['email'],
        'alert' => $_SESSION['alert'],
    ];

    return $response;
}
