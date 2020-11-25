<?php

namespace App\Model;

use Dumb\Dumb;
use PDO;
use PDOStatement;

class SqlManager
{
    /** @var PDO */
    protected $db;

    public function __construct()
    {
        $this->db = Dumb::getContainer()->('db');
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return Dumb::getContainer()->($name);
    }

    /**
     * @return bool|int|PDOStatement
     */
    public function sqlRequest(string $request, array $array = [], bool $bool = false)
    {
        $obj = $this->db->prepare($request);
        $obj->execute($array);
        if ($bool) {
            return $obj->rowCount();
        }

        return $obj;
    }

    /**
     * @return mixed
     */
    public function sqlRequestFetch(string $request, array $array = [])
    {
        return $this->sqlRequest($request, $array)->fetch(PDO::FETCH_ASSOC);
    }
}
