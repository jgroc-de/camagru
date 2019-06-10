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
    public function get()
    {
        $filters = $this->container['camagru']($this->container)->getFilters();
		$this->response['filters'] = $filters;
    }
}
