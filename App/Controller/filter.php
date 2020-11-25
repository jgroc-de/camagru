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

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->filterManager = Dumb::$container['filter'](Dumb::$container);
    }

    public function get(): void
    {
        $filters = $this->filterManager->getFilters();
        $this->response['filters'] = $filters;
    }
}
