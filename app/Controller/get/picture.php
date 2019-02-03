<?php

declare(strict_types=1);

namespace App\Controller\get;

use Dumb\Patronus;

class picture extends Patronus
{
    private $elem;

    private $comments;

    public function trap(array $c)
    {
        $id = $_GET['id'];

        $this->elem = $c['picture']($c)->getPic($id);
        if (!$this->elem || empty($this->elem))
        {
            $this->code = 404;
        }
        else
        {
            $this->comments = $c['comment']($c)->getComments($id)->fetchAll();
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
