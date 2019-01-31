<?php

namespace App\Controller\post;

use Dumb\Dumbee;

/**
 * listpicsByDate.
 *
 * @param Dumbee $container
 * @param array  $options
 *
 * @return array $response
 */
class listpicsByDate
{
	public $code;

	public $args;

	public function __construct(Dumbee $container, array $options)
	{
		$this->args = [
			'pics' => $container->picture->getPics(($_POST['start'] - 1) * 4),
			'start' => $_POST['start'] + 1,
			'url' => '/listPicsByDate',
		];
		$this->code = empty($this->args['pics']) ? 404 : 200;
	}
}
