<?php

declare(strict_types=1);

namespace App\Controller\get;

use Dumb\Patronus;

class home extends Patronus
{
    public function bomb(array $options)
    {
        $onLoad = "ggDestroy(document.getElementById('launch'), 'carroussel', '/listPicsByDate');";
        $components = $options['components'];
        $components['body'] = $onLoad;
        $main = '/homeView.html';
        $view = 'Last Pictures';

        require __DIR__.'/../../view/template.php';
    }
}
