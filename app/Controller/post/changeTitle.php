<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class changeTitle extends Patronus
{
    public function trap(array $c)
    {
        $this->response = $c['picture']($c)->changeTitle($_POST['id'], $_POST['title']);
    }
}
