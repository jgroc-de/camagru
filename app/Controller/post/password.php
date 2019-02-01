<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class password extends Patronus
{
    public function trap(Dumbee $c)
    {
        $c->user->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }
}
