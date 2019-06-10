<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * home
 * provide home view.
 */
class home extends Patronus
{
    public function get()
    {
    }

    public function bomb(array $options = null)
    {
        ob_start();
        require __DIR__.'/../View/template.html';
        ob_end_flush();
    }
}
