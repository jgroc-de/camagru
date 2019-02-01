<?php

declare(strict_types=1);

namespace App\Controller\get;

use Dumb\Dumbee;
use Dumb\Patronus;

class camagru extends Patronus
{
    private $pics;

    private $listFilter;

    public function trap(Dumbee $c)
    {
        $this->pics = $c->picture->getPicsByLogin($_SESSION['id']);
        $this->listFilter = $c->camagru->getFilters();
    }

    public function bomb(array $options)
    {
        array_shift($options['header']);
        $listFilter = $this->listFilter;
        $pics = $this->pics;
        if (!empty($listFilter))
        {
            $count = (int) (12 / count($listFilter));
        }
        $options['script'] = 'js/camagruView.js';
        $view = 'Camagru Factory';
        $main = '/camagruView.html';
        $components = $options['components'];

        require __DIR__.'/../../view/template.php';
    }
}
