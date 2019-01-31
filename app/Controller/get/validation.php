<?php

namespace App\Controller\get;

use Dumb\Dumbee;

/**
 * validation.
 *
 * @param Dumbee $container
 * @param array  $options
 */
class validation
{
	public function __construct(Dumbee $c, array $options)
	{
		if (isset($_GET['log'], $_GET['key']))
		{
			$c->user->checkValidationMail($_GET['log'], $_GET['key']);
		}
	}
}
