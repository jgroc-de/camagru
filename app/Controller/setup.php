<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class setup extends Patronus
{
    public function get(array $c)
    {
        $configManager = $c['config']($c);
        $configManager->createDB(file_get_contents($c['env']()['export']));
    }

    public function bomb(array $options)
    {
        header('Location: /');
    }
}
