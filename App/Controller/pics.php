<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\PicturesManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Response;
use App\Library\Exception;

class pics extends Patronus
{
    /** @var PicturesManager */
    private $picsManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->picsManager = Dumb::getContainer()->get('picture');
    }

    public function get(): void
    {
        $pics = $this->getPics();
        $max = $this->picsManager->countPics();
        if (empty($pics)) {
            throw new Exception('pics', Response::NOT_FOUND);
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
                throw new Exception("{$sort}: method not allowed", Response::BAD_REQUEST);
        }
    }
}
