<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * camagru
 * give the view to creates pics
 */
class camagru extends Patronus
{
    private $pics;

    private $listFilter;

    public function get(array $c)
    {
        $this->pics = $c['picture']($c)->getPicsByLogin($_SESSION['id']);
        $this->listFilter = $c['camagru']($c)->getFilters();
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

        require __DIR__.'/../../View/template.html';
    }
}
