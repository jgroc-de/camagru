<?php

namespace App\Model;

use PDO;

class FilterManager extends SqlManager
{
    public function getFilters(): ?array
    {
        $tab = [];

        $request = $this->db->query('SELECT * FROM filter');
        while ($elemt = $request->fetch(PDO::FETCH_ASSOC)) {
            $tab[] = $elemt;
        }

        return $tab;
    }
}
