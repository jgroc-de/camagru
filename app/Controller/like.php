<?php

declare(strict_types=1);

namespace App\Controller\Post;

use Dumb\Patronus;

class like extends Patronus
{
    public function post(array $c)
    {
        $this->response['likes_counter'] = $c['picture']($c)->addlike($_POST['id']);
        if ($this->response['likes_counter'] < 0)
        {
            $this->response['flash'] = 'Already liked!';
        }
    }
}
