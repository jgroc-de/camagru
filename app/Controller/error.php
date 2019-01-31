<?php

namespace App\Controller;

use Dumb\Dumbee;

class error
{
	public function __construct(Dumbee $c, array $options)
	{
		if (!isset($options['code']))
		{
			$options['code'] = 404;
			$options['message'] = 'Not Found';
		}
		header('HTTP/1.1 '.$options['code'].' '.$options['message']);
		$options['components'] = [
			'/common/about.php',
			'/common/contact.php',
		];
		$options['header'] = [
			'/common/error.php',
		];
		require __DIR__.'/../view/template.php';
	}
}
