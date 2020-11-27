<?php

namespace App\MiddleWares;

use App\Model\PicturesManager;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;
use App\Library\Exception;

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
            throw new Exception('Picture not found', Response::NOT_FOUND);
        }
        if ($_SESSION['id'] !== $pic['author_id']) {
            throw new Exception('Picture not yours', Response::FORBIDDEN);
        }
    }
}
