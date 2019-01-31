<?php

namespace App\Model;

use Dumb\Dumbee;

class SqlManager
{
    protected $container;

    /**
     * __construct.
     *
     * @param mixed $container
     */
    public function __construct(Dumbee &$container)
    {
        $this->container = $container;
    }

    /**
     * __get.
     *
     * @param mixed $name
     */
    public function __get(string $name)
    {
        return $this->container->{$name};
    }

    /**
     * sqlRequest.
     *
     * @param mixed $request
     * @param mixed $array
     * @param mixed $bool
     */
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

    /**
     * sqlRequestFetch.
     *
     * @param mixed $request
     * @param mixed $array
     */
    protected function sqlRequestFetch($request, array $array = [])
    {
        return $this->sqlRequest($request, $array)->fetch();
    }
}
