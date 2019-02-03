<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class addComment extends Patronus
{
    public function trap(array $c)
    {
        $id = $_POST['id'];
        $user = $c['user']($c)->getUserByImgId($id);

        if (empty($user))
        {
            $this->code = 404;
        }
        else
        {
            $commentManager = $c['comment']($c);
            $commentManager->addComment();
            if ($user['alert'])
            {
                $c['mail']()->sendCommentMail($user);
            }
            $this->response = $commentManager->getCommentByImgId($id);
        }
    }
}
