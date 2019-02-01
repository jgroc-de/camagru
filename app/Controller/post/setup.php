<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class setup extends Patronus
{
    public function trap(Dumbee $c)
    {
        //if ($_SESSION['pseudo'] === 'troll2')
        //{
        $env = $c->env;
        $c->config->createDB($env['name']);
        $c->config->request(file_get_contents($env['export']));
        //}
    }

    public function bomb(array $options)
    {
        header('Location: index.php');
    }
}
