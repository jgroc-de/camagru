<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class addLike extends Patronus
{
    public function trap(array $c)
    {
        $this->response['likes_counter'] = $c['picture']($c)->addlike($_POST['id']);
        if ($this->response['likes_counter'] < 0)
        {
            $this->response['flash'] = 'Already liked!';
        }
    }
}
