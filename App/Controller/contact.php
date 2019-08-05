<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class contact extends Patronus
{
    public function post()
    {
        $this->response['flash'] = 'Thx!';
    }

    public function bomb(array $response = null)
    {
        echo json_encode($this->response);
        $this->container['mail']()->sendContactMail();
    }
}
