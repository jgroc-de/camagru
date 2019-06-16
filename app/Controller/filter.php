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

    protected function setup()
    {
        $this->filterManager = $this->container['filter']($this->container);
    }

    public function get()
    {
        $filters = $this->filterManager->getFilters();
        $this->response['filters'] = $filters;
    }
}
