<?php

function error($c, $error, $options)
{
    if (!$error)
    {
        $error = [];
        $error['error']['code'] = 404;
        $error['error']['message'] = 'Not Found';
    }
    header('HTTP/1.1 '.$error['error']['code'].' '.$error['error']['message']);
    $components = [
        '/common/about.php',
        '/common/contact.php',
    ];
    $header = [
        '/common/error.php',
    ];
    require __DIR__.'/../../view/template.php';
    exit;
}
