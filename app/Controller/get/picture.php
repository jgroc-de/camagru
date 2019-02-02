<?php

declare(strict_types=1);

namespace App\Controller\get;

use Dumb\Dumbee;
use Dumb\Patronus;

class picture extends Patronus
{
    private $elem;

    private $comments;

    public function trap(Dumbee $c)
    {
        $id = $_GET['id'];
        $picManager = $c->picture;

        if (!($picManager->picInDb($id)))
        {
            $this->code = 404;
        }
        else
        {
            $this->elem = $picManager->getPic($id);
            $this->comments = $c->comment->getComments($id)->fetchAll();
        }
    }

    public function bomb(array $options)
    {
        $id = $_GET['id'];
        $elem = $this->elem;
        $comments = $this->comments;
        array_shift($options['header']);
        $options['title2'] = htmlspecialchars($elem['title']);
        $view = 'Picture';
        $main = '/picView.html';
        $options['components'] = [];

        require __DIR__.'/../../view/template.html';
    }
}
