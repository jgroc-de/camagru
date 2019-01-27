<?php

/**
 * @class Dumbee
 */
class Dumbee
{
    protected $container = array();

    public function __construct(array $functions)
    {
        $this->container = $functions;
    }

    public function __get($key)
    {
        return $this->container[$key]($this);
    }
}
