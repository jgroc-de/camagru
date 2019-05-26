<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class setup extends Patronus
{
    public function post()
    {
        $configManager = $this->container['config']($this->container);
        $configManager->createDB(file_get_contents($this->container['env']()['export']));
    }

    public function bomb(array $options)
    {
        header('Location: /');
    }
}
