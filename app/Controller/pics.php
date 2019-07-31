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
        $max = $this->picsManager->countPics()['count'];
        if (empty($pics)) {
            throw new \Exception('pics', Response::NOT_FOUND);
        }
        $this->response = [
            'pictures' => $pics,
            'page' => $_GET['id'],
            'max' => $max,
        ];
    }

    private function getPics(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI'])[1];
        $sort = explode('By', $uri)[1];
        if (!isset($_GET['id'])) {
            $_GET['id'] = 0;
        }

        switch ($sort) {
            case 'Date':
                return $this->picsManager->getPicsByDate($_GET['id'] * 8);
            case 'Like':
                return $this->picsManager->getPicsByLike($_GET['id'] * 8);
            case 'User':
                return $this->picsManager->getPicsByUser($_SESSION['id']);
            default:
                throw new \Exception("{$sort}: method not allowed", Response::BAD_REQUEST);
        }
    }
}
