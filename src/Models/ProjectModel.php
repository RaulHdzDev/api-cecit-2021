<?php

namespace App\Models;

class ProjectModel
{
    public $projectId;
    public $assessorId;
    public $categoryId;
    public $modalityId;
    public $campusId;
    public $areaId;
    public $name;
    public $description;
    public $url;
    public $image;
    public $imageUrl;

    public function __construct(array $projectParams)
    {
        $this->projectId = $projectParams['project_id'] ?? 0;
        $this->assessorId = $projectParams['assessor_id'] ?? 0;
        $this->categoryId = $projectParams['id_category'] ?? 0;
        $this->modalityId = $projectParams['id_modality'] ?? 0;
        $this->campusId = $projectParams['id_sedes'] ?? 0;
        $this->areaId = $projectParams['id_area'] ?? 0;
        $this->name = $projectParams['project_name'] ?? '';
        $this->description = $projectParams['project_description'] ?? '';
        $this->url = $projectParams['url_video'] ?? '';
        $this->image = $projectParams['project_image'] ?? '';
        $this->imageUrl = $projectParams['project_image_url'] ?? '';
    }
}
