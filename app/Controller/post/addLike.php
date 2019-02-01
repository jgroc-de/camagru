<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class addLike extends Patronus
{
    public function trap(Dumbee $c)
    {
        $picManager = $c->picture;

        if (($picManager->picInDb($_POST['id'])))
        {
            $this->response['likes_counter'] = $picManager->addlike($_POST['id']);
            if ($this->response['likes_counter'] < 0)
            {
                $this->code = 200;
                $this->response['flash'] = 'Already liked!';
            }
        }
        else
        {
            $this->code = 404;
        }
    }
}
