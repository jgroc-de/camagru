<?php

namespace App\Model;

class FilterManager extends SqlManager
{
    public function getFilters()
    {
        $tab = [];

        $request = $this->db->query('SELECT * FROM filter');
        while ($elemt = $request->fetch(\PDO::FETCH_ASSOC)) {
            $tab[] = $elemt;
        }

        return $tab;
    }
}
