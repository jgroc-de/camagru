<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class like extends Patronus
{
    public function post()
    {
        $this->response['likes_counter'] = $this->container['picture']($this->container)->addlike($_POST['id']);
        if ($this->response['likes_counter'] < 0) {
            $this->response['flash'] = 'Already liked!';
        }
    }

    public function delete()
    {
    }

    public function patch()
    {
    }
}
