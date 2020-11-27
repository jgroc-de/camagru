<?php

namespace App\MiddleWares;

use App\Library\Exception;
use App\Model\CommentManager;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class checkCommentProperty extends DumbMiddleware
{
    /** @var CommentManager */
    private $commentManager;

    public function __construct(CommentManager $commentManager)
    {
        $this->commentManager = $commentManager;
    }

    public function check(ServerRequestInterface $request): void
    {
        $id = $request->getQueryParams()['id'];
        $comment = $this->commentManager->getComment($id);

        if (empty($comment)) {
            throw new Exception('Comment not found', Response::NOT_FOUND);
        }
        if ($_SESSION['id'] !== $comment['author_id']) {
            throw new Exception('Comment not yours', Response::FORBIDDEN);
        }
    }
}
