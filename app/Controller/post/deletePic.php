<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class deletePic extends Patronus
{
    public function trap(array $c)
    {
        $this->response['url'] = $_POST['url'];
        $c['picture']($c)->deletePic($_POST['id'], (int)$_SESSION['id']);
        unlink($_POST['url']);
        $this->response['flash'] = 'Picture successfully deleted!';
    }
}
