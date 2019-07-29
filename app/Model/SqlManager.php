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

    public function sqlRequest($request, array $array = [], bool $bool = false)
    {
        $obj = $this->db->prepare($request);
        $success = $obj->execute($array);
        if ($bool) {
            return $obj->rowCount();
        }

        return $obj;
    }

    public function sqlRequestFetch($request, array $array = [])
    {
        return $this->sqlRequest($request, $array)->fetch();
    }
}
