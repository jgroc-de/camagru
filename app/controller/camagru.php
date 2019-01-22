<?php

function camagru($c, $options)
{
	array_shift($options['header']);

	$pics = $c->picture->getPicsByLogin($_SESSION['id']);
	$listFilter = $c->camagru->getFilters();	
	$options['script'] = 'js/camagruView.js';
	$view = 'Camagru Factory';
	$main = '/camagruView.html';
	$components = $options['components'];
	require __DIR__.'/../view/template.php';
}
