<?php

declare(strict_types=1);

namespace Dumb;

/**
 * @class Dumbee
 */
class Dumbee
{
    protected $container = [];

    /**
     * __construct.
     *
     * @param array $functions
     */
    public function __construct(array $functions)
    {
        $this->container = $functions;
    }

    /**
     * __get.
     *
     * @param string $key
     */
    public function __get(string $key)
    {
        return $this->container[$key]($this);
    }
}
