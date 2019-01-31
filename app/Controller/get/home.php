<?php

namespace App\Controller\get;

use Dumb\Dumbee;

/**
 * home.
 *
 * @param Dumbee $container
 * @param array  $options
 */
class home
{
	public function __construct(Dumbee $container, array $options)
	{
		$components = $options['components'];

		$onLoad = "ggDestroy(document.getElementById('launch'), 'carroussel', '/listPicsByDate');";
		$components['body'] = $onLoad;
		$main = '/homeView.html';
		$view = 'Last Pictures';
		require __DIR__.'/../../view/template.php';
	}
}