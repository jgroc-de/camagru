<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class logout extends Patronus
{
    public function trap(Dumbee $c)
    {
        session_unset();
        session_destroy();
    }
}
