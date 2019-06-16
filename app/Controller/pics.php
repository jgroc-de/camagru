<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;
use Dumb\Response;

class pics extends Patronus
{
    private $picsManager;

    protected function setup()
    {
        $this->picsManager = $this->container['picture']($this->container);
    }

    public function get()
    {
        $pics = $this->getPics();
        if (empty($pics)) {
            throw new \Exception('pics', Response::NOT_FOUND);
        }
        $this->response = [
            'pics' => $pics,
            'start' => $_POST['start'] + 1,
        ];
    }

    private function getPics(): array
    {
        switch ($_GET['by']) {
            case 'date':
                return $this->picsManager->getPicsByDate(($_GET['start'] - 1) * 8);
               case 'like':
                return $this->picsManager->getPicsByLike(($_GET['start'] - 1) * 8);
            case 'user':
                return $this->picsManager->getPicsByUser($_SESSION['id']);
            default:
                throw new \Exception('method not allowed', Response::BAD_REQUEST);
        }
    }
}
