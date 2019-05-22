<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class pics extends Patronus
{
    public function get(array $c)
    {
        if ($_GET['by'] == 'date')
        {
            $pics = $c['picture']($c)->getPicsByDate(($_GET['start'] - 1) * 8);
            $url = '/listPicsByDate';
        }
        else if ($_GET['by'] == 'like')
        {
            $pics = $c['picture']($c)->getPicsByLike(($_GET['start'] - 1) * 8);
            $url = '/listPicsByLike';
        }
        if (empty($pics))
        {
            $this->code = 404;
        }
        else
        {
            $this->response = [
                'pics' => $pics,
                'start' => $_POST['start'] + 1,
                'url' => $url,
            ];
        }
    }
}
