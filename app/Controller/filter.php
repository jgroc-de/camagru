<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * filter
 * get filters.
 */
class filter extends Patronus
{
	private $filterManager;

    public function get()
    {
        $filters = $this->filterManager->getFilters();
		$this->response['filters'] = $filters;
    }

	protected function setup()
	{
        $this->filterManager = $this->container['camagru']($this->container);
	}
}
