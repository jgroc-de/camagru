<?php

/**
 * @class Twittee
 *
 * @author: fabien Potencier
 */
class Twittee
{
    protected $container = array();

    public function __set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function __get($key)
    {
        return $this->container[$key]($this);
    }
}
