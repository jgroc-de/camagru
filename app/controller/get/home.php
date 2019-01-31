<?php

/**
 * home.
 *
 * @param Dumbee $container
 * @param array  $options
 */
function home(Dumbee $container, array $options)
{
    $components = $options['components'];
	
	$onLoad = "ggAjax('&start=1', '/listPicsByDate', listPics);ggAjax('&start=2', '/listPicsByDate', listPics);ggAjax('&start=3', '/listPicsByDate', listPics);";
	$components['body'] = $onLoad;
    $main = '/homeView.html';
    $view = 'Last Pictures';
    require __DIR__.'/../../view/template.php';
}
