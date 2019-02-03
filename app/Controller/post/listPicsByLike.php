<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class listPicsByLike extends Patronus
{
    public function trap(array $c)
    {
        $pics = $c['picture']($c)->getPicsByLike(($_POST['start'] - 1) * 8);
        if (!$pics)
        {
            $this->code = 404;
        }
        else
        {
            $this->response = [
                'pics' => $pics,
                'start' => $_POST['start'] + 1,
                'url' => '/listPicsByLike',
            ];
        }
    }
}
