<?php

namespace App\Controller;

use Dumb\Patronus;

class admin extends Patronus
{
    public function get(Request $request): void
    {
        echo phpinfo();
    }
}
