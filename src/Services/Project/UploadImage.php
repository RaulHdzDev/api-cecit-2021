<?php

namespace App\Services\Project;

use App\App\Constants;
use App\App\Database;
use App\Models\AssessorModel;
use App\Models\AuthorModel;
use App\Models\ProjectModel;


class UploadImage
{
    private AssessorModel $assessor;
    private AuthorModel $firstAuthor;
    private ProjectModel $project;

    public function __construct(array $params)
    {
        $this->firstAuthor = new AuthorModel(array(
            'author_id' => $params['author_id']
        ));
        $this->project = new ProjectModel(array(
            'project_image' => $params['project_image']
        ));
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {

            if ($this->project->image != "") {
                $projectImageDirectory = DIRECTORY_SEPARATOR . 'projects';
                $projectImageExtension = pathinfo($this->project->image->getClientFilename(), PATHINFO_EXTENSION);
                $projectImageBasename = 'proyecto-' . $this->firstAuthor->authorId;
                $projectImageFilename = sprintf('%s.%0.8s', $projectImageBasename, $projectImageExtension);
                $this->project->image->moveTo(Constants::FILE_UPLOAD_BASE_DIR . $projectImageDirectory . DIRECTORY_SEPARATOR . $projectImageFilename);
                $this->project->imageUrl = $projectImageDirectory . DIRECTORY_SEPARATOR . $projectImageFilename;
            } else {
                $this->project->imageUrl = "";
            }

            $sql =
                "CALL SP_update_project_image (
                    :imagen_in,
                    @result,
                    :id_autores_in
                )";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':imagen_in', $this->project->imageUrl, \PDO::PARAM_STR);
            $stmt->bindParam(':id_autores_in', $this->firstAuthor->authorId, \PDO::PARAM_INT);

            $stmt->execute();

            return [
                'error'  => false,
                'status' => 200,
                'data' => array('message' => 'Se ha subido la imagen correctamente')
            ];
        } catch (\Exception $exception) {
            return [
                'error'  => true,
                'status' => 500,
                'data' => array('message' => 'Ocurrió un error en el servidor: ' . $exception->getMessage())
            ];
        }
    }
}
