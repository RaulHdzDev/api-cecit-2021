<?php

namespace App\Models;

class CampusModel
{
    public $campusId;
    public $campus;

    public function __construct(array $campusParams)
    {
        $this->campusId = $campusParams['id_sedes'] ?? 0;
        $this->campus = $campusParams['campus'] ?? '';
    }
}
