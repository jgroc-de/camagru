<?php

declare(strict_types=1);

namespace Dumb;

/**
 * this is the midleware system.
 */
class IronWall
{
    private $functions = [];

    public function __construct()
    {
    }

    public function add($function)
    {
        $this->functions[] = $function;
    }

    public function check()
    {
        foreach ($this->functions as $function) {
            $function();
        }
    }
}
