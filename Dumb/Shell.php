<?php

declare(strict_types=1);

namespace Dumb;

/**
 * this is the third layer of security which will do somme DB request
 */
class Shell
{
    private $ghosts = [];

	public function add($function)
	{
		$this->ghosts[] = $function;
	}

	public function check($container)
	{
        foreach ($this->ghosts as $ghost) {
            $ghost($container);
        }
	}
}
