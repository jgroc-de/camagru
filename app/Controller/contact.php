<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class contact extends Patronus
{
    public function post()
    {
        $this->container['mail']()->sendContactMail();
        $this->response['flash'] = 'Thx!';
    }
}
