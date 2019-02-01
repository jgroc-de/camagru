<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class contact extends Patronus
{
    public function trap(Dumbee $container)
    {
        $container->mail->sendContactMail();
        $this->response['flash'] = 'Thx!';
    }
}
