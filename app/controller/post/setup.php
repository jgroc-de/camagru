<?php

function setup($c)
{
    //if ($_SESSION['pseudo'] === 'troll2')
    //{
    $env = $c->env;
    $c->config->createDB($env['name']);
    $c->config->request(file_get_contents($env['export']));
    //}
    header('Location: index.php');
}
