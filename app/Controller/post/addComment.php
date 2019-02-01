<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class addComment extends Patronus
{
    public function trap(Dumbee $c)
    {
        $commentManager = $c->comment;
        $id = $_POST['id'];

        if (!($c->picture->picInDb($id)))
        {
            $this->code = 404;
        }
        else
        {
            $commentManager->addComment();
            $user = $c->user->getUserByImgId($id);
            if ($user['alert'])
            {
                $c->mail->sendCommentMail($user);
            }
            $this->response = $commentManager->getCommentByImgId($id);
        }
    }
}
