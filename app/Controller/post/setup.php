<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class setup extends Patronus
{
    public function trap(array $c)
    {
        //if ($_SESSION['pseudo'] === 'troll2')
        //{
        $env = $c['env']();
        $configManager = $c['config']($c);
        $configManager->createDB($env['name']);
        $configManager->exec(file_get_contents($env['export']));
        //}
    }

    public function bomb(array $options)
    {
        header('Location: index.php');
    }
}
