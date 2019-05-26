<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class pics extends Patronus
{
    public function get()
    {
        $picsManager = $this->container['picture']($this->container);
        if ($_GET['by'] == 'date')
        {
            $pics = $picsManager->getPicsByDate(($_GET['start'] - 1) * 8);
        }
        else if ($_GET['by'] == 'like')
        {
            $pics = $picsManager->getPicsByLike(($_GET['start'] - 1) * 8);
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
            ];
        }
    }
}
