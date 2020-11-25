<?php

namespace App\Library\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /** @var array */
    private $services;

    public function setAll(array $services): void
    {
        foreach($services as $id => $function) {
            $this->services[$id] = $function;
        }
    }

    public function get($id)
    {
        if (!isset($this->services[$id])) {
            throw new NotFoundException($id);
        }

        try {
            return $this->services[$id]();
        } catch (\Exception $e) {
            throw new ContainerException($id);
        }
    }

    public function has($id)
    {
        return isset($this->services[$id]);
    }
}
