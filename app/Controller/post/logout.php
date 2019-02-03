<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class logout extends Patronus
{
    public function trap(array $c)
    {
        session_unset();
        session_destroy();
    }
}
