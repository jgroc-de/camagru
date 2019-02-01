<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class deletePic extends Patronus
{
    public function trap(Dumbee $c)
    {
        $this->response['url'] = $_POST['url'];
        $picManager = $c->picture;
        $pic = $picManager->getPicByUrl($_POST['url']);

        if (!empty($pic) && $_SESSION['id'] === $pic['id_author'])
        {
            $picManager->deletePic((int) $pic['id'], (int) $pic['id_author']);
            unlink($_POST['url']);
            $this->response['flash'] = 'Picture successfully deleted!';
        }
        else
        {
            $this->code = 404;
        }
    }
}
