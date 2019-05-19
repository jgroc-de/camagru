<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * home
 * provide home view
 */
class home extends Patronus
{
    public function bomb(array $options)
    {
        $this->{$this->method}($options);
    }

    private function get(array $options)
    {
        $onLoad = "ggDestroy(document.getElementById('launch'), 'carroussel', '/listPicsByDate');";
        $components = $options['components'];
        $components['body'] = $onLoad;
        $main = '/homeView.html';
        $view = 'Last Pictures';

        require __DIR__.'/../View/template.html';
    }
}
