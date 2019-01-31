<?php

namespace App\Controller\get;

use Dumb\Dumbee;

/**
 * home.
 *
 * @param Dumbee $container
 * @param array  $options
 */
interface getRoutes
{
	public function __construct(Dumbee $container, array $options);
}
