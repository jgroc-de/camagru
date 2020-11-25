<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\ConfigManager;
use Dumb\Dumb;
use Dumb\Patronus;

class setup extends Patronus
{
    /** @var ConfigManager */
    private $configManager;
    /** @var string */
    private $export;

    public function __construct(string $method, int $code = 302)
    {
        parent::__construct($method, $code);
        $this->configManager = Dumb::getService('config');
        $this->export = Dumb::getService('env')['export'];
    }

    public function get(): void
    {
        $this->configManager->createDB(file_get_contents($this->export));
    }

    public function bomb(): string
    {
        header('Location: /');

        return '';
    }
}
