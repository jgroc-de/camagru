<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class pics extends Patronus
{
    public function get()
    {
        $picsManager = $this->container['picture']($this->container);
        if ('date' == $_GET['by']) {
            $pics = $picsManager->getPicsByDate(($_GET['start'] - 1) * 8);
        } elseif ('like' == $_GET['by']) {
            $pics = $picsManager->getPicsByLike(($_GET['start'] - 1) * 8);
        }
        if (empty($pics)) {
            throw new \Exception('pics', 404);
        }
        $this->response = [
            'pics' => $pics,
            'start' => $_POST['start'] + 1,
        ];
    }
}
