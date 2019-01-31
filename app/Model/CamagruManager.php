<?php

namespace App\Model;

class CamagruManager extends SqlManager
{
    /**
     * getFilters.
     *
     * @return array
     */
    public function getFilters()
    {
        $tab = [];

        $request = $this->db->query('SELECT * FROM filter');
        while ($elemt = $request->fetch())
        {
            $tab[] = $elemt;
        }

        return $tab;
    }
}
