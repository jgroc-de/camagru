<?php

function password($c, $options)
{
    $userManager = $c->user;

    $password = $_POST['password'];
    $userManager->updatePassword($password);
    $response['code'] = 200;
    $response['flash'] = 'Password Succesfully updated';
    return $response;
}
