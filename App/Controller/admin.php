<?php

namespace App\Controller;

use Dumb\Patronus;
use Dumb\Request;

class admin extends Patronus
{
    public function get(Request $request): void
    {
        echo phpinfo();
    }
}
