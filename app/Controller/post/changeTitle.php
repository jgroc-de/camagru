<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class changeTitle extends Patronus
{
    public function trap(Dumbee $c)
    {
        $id = $_POST['id'];
        $picManager = $c->picture;

        if ($picManager->picInDb($id))
        {
            $this->response = $picManager->changeTitle($id, $_POST['title']);
        }
    }
}
