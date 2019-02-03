<?php

namespace App\Model;

class SqlManager
{
    protected $container;

    protected $db;

    public function __construct(array $container = [])
    {
        $this->container = $container;
        $this->db = $container['db']($container['env']());
    }

    public function __get(string $name)
    {
        return $this->container->{$name};
    }

    protected function sqlRequest($request, array $array = [], bool $bool = false)
    {
        $obj = $this->db->prepare($request);
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
