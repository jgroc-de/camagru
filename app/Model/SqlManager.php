<?php

namespace App\Model;

use Dumb\Dumbee;

class SqlManager
{
    protected $container;

    public function __construct(Dumbee &$container)
    {
        $this->container = $container;
    }

    public function __get(string $name)
    {
        return $this->container->{$name};
    }

    protected function sqlRequest($request, array $array = [], bool $bool = false)
    {
        $db = $this->container->db;

        $obj = $db->prepare($request);
        $success = $obj->execute($array);
        if ($bool)
        {
            return $success;
        }

        return $obj;
    }

    protected function sqlRequestFetch($request, array $array = [])
    {
        return $this->sqlRequest($request, $array)->fetch();
    }
}
