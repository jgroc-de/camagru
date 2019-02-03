<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class getSettings extends Patronus
{
    public function trap(array $c)
    {
        $this->response['settings'] = [
            'pseudo' => $_SESSION['pseudo'],
            'email' => $_SESSION['email'],
            'alert' => $_SESSION['alert'],
        ];
    }
}
