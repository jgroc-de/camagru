<?php

function camagru($c, $options)
{
    $options['camagru'] = true;

    if (!isset($_SESSION['pseudo']))
    {
		$target = 'index.php?action=login&action2=camagru';
		$view = 'Log IN';
		$main = '/loginView.html';
	}
    else
    {
        $pics = $c->picture->getPicsByLogin($_SESSION['id']);
		$listFilter = $c->camagru->getFilters();	
        $options['script'] = 'public/js/camagruView.js';
		$view = 'Camagru Factory';
		$main = '/camagruView.html';
		require __DIR__.'/../view/template.php';
	}
}
