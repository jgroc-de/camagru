<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class listPicsByLike extends Patronus
{
    public function trap(Dumbee $container)
    {
        $pics = $container->picture->getPicsByLike(($_POST['start'] - 1) * 4);
        if (empty($pics))
        {
            $this->code = 404;
        }
        else
        {
            $this->response = [
                'pics' => $pics,
                'code' => $this->code,
                'start' => $_POST['start'] + 1,
                'url' => '/listPicsByDate',
            ];
        }
    }
}
