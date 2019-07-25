<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class setup extends Patronus
{
    private $configManager;

    protected function setup()
    {
        $this->configManager = $this->container['config']($this->container);
    }

    public function get()
    {
        $this->configManager->createDB(file_get_contents($this->container['env']()['export']));
    }

    public function bomb(array $options = null)
    {
        header('Location: /');
    }
}
