<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\ConfigManager;
use Dumb\Patronus;

class setup extends Patronus
{
    /** @var ConfigManager */
    private $configManager;
    /** @var string */
    private $export;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->configManager = $container['config']($container);
        $this->export = $container['env']()['export'];
        $this->method = $method;
        $this->code = $code;
    }

    public function get()
    {
        $this->configManager->createDB(file_get_contents($this->export));
    }

    public function bomb(): string
    {
        header('Location: /');
        return "";
    }
}
