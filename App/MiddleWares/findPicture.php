<?php

namespace App\MiddleWares;

use App\Model\PicturesManager;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class findPicture extends DumbMiddleware
{
    /** @var PicturesManager */
    private $pictureManager;

    public function __construct(PicturesManager $pictureManager)
    {
        $this->pictureManager = $pictureManager;
    }

    public function check(ServerRequestInterface $request): void
    {
        $id = (int) $_GET['id'];
        if (!($this->pictureManager->picInDb($id))) {
            throw new \Exception('Picture not found', Response::NOT_FOUND);
        }
    }
}
