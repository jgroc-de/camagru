<?php

namespace App\MiddleWares;

use App\Library\Exception;
use App\Model\PicturesManager;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class checkPictureProperty extends DumbMiddleware
{
    /** @var PicturesManager */
    private $pictureManager;

    public function __construct(PicturesManager $pictureManager)
    {
        $this->pictureManager = $pictureManager;
    }

    public function check(ServerRequestInterface $request): void
    {
        $id = $request->getQueryParams()['id'];
        $pic = $this->pictureManager->getPic($id);

        if (empty($pic)) {
            throw new Exception('Picture not found: ' . $id, Response::NOT_FOUND);
        }
        if ($_SESSION['id'] !== $pic['author_id']) {
            throw new Exception('Picture not yours: ' . $id, Response::FORBIDDEN);
        }
    }
}
