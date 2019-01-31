<?php

/**
 * listpicsByLike.
 *
 * @param Dumbee $container
 * @param array  $options
 *
 * @return array $response
 */
function listpicsByLike(Dumbee $container, array $options)
{
	return [
		'pics' => $container->picture->getPicsByLike(($_POST['start'] - 1) * 4), 
		'code' => 200,
	];
}
