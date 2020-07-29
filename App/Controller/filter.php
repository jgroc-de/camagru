<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\FilterManager;
use Dumb\Patronus;

/**
 * filter
 * get filters.
 */
class filter extends Patronus
{
    /** @var FilterManager */
    private $filterManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->filterManager = $container['filter']($container);
    }

    public function get()
    {
        $filters = $this->filterManager->getFilters();
        $this->response['filters'] = $filters;
    }
}
