<?php

namespace App\Models;

class AreaModel
{
    public $areaId;
    public $area;

    public function __construct(array $areaParams)
    {
        $this->areaId = $areaParams['id_area'] ?? 0;
        $this->area = $areaParams['area'] ?? '';
    }
}
