<?php

namespace App\Model;

class CamagruManager extends SqlManager
{
    public function getFilters()
    {
        $tab = [];

        $request = $this->container->db->query('SELECT * FROM filter');
        while ($elemt = $request->fetch())
        {
            $tab[] = $elemt;
        }

        return $tab;
    }
}
