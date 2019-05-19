<?php

declare(strict_types=1);

namespace App\Controller\Patch;

use Dumb\Patronus;

class password extends Patronus
{
    public function trap(array $c)
    {
        $c['user']($c)->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }
}
