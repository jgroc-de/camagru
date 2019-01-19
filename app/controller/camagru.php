<?php

function camagru($c, $options)
{
	$options['camagru'] = true;

	$pics = $c->picture->getPicsByLogin($_SESSION['id']);
	$listFilter = $c->camagru->getFilters();	
	$options['script'] = 'public/js/camagruView.js';
	$view = 'Camagru Factory';
	$main = '/camagruView.html';
	$components = $options['components'];
	require __DIR__.'/../view/template.php';
}
