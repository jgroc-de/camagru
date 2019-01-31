<?php

/**
 * camagru.
 *
 * @param Dumbee $c
 * @param array  $options
 */
function camagru(Dumbee $c, array $options)
{
    array_shift($options['header']);

    $pics = $c->picture->getPicsByLogin($_SESSION['id']);
    $listFilter = $c->camagru->getFilters();
    $count = (int) (12 / count($listFilter));
    $options['script'] = 'js/camagruView.js';
    $view = 'Camagru Factory';
    $main = '/camagruView.html';
    $components = $options['components'];
    require __DIR__.'/../../view/template.php';
}
