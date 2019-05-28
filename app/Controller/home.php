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

    public function bomb(array $options)
    {
        require __DIR__.'/../View/template.html';
    }
}
