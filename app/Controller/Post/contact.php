<?php

declare(strict_types=1);

namespace App\Controller\Post;

use Dumb\Patronus;

class contact extends Patronus
{
    public function trap(array $c)
    {
        $c['mail']()->sendContactMail();
        $this->response['flash'] = 'Thx!';
    }
}
