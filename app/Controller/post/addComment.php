<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class addComment extends Patronus
{
    public function trap(array $c)
    {
        $commentManager = $c['comment']($c);
        $id = $_POST['id'];

        $commentManager->addComment();
        $user = $c['user']($c)->getUserByImgId($id);
        if (empty($user))
        {
            $this->code = 404;
        }
        else
        {
            if ($user['alert'])
            {
                $c['mail']()->sendCommentMail($user);
            }
            $this->response = $commentManager->getCommentByImgId($id);
        }
    }
}
