<?php

declare(strict_types=1);

namespace App\Controller\Get;

use Dumb\Patronus;

class listPicsByDate extends Patronus
{
    public function trap(array $c)
    {
        $pics = $c['picture']($c)->getPics(($_POST['start'] - 1) * 8);
        if (!$pics)
        {
            $this->code = 404;
        }
        else
        {
            $this->response = [
                'pics' => $pics,
                'start' => $_POST['start'] + 1,
                'url' => '/listPicsByDate',
            ];
        }
    }
}
