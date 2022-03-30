<?php

namespace App\Models;

class ModalityModel
{
    public $modalityId;
    public $modality;

    public function __construct(array $modalityParams)
    {
        $this->modalityId = $modalityParams['id_modality'] ?? 0;
        $this->modality = $modalityParams['modality'] ?? '';
    }
}
