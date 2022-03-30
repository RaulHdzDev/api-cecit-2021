<?php

namespace App\Services\Project;

use App\App\Constants;
use App\App\Database;
use App\Models\AssessorModel;
use App\Models\AuthorModel;
use App\Models\ProjectModel;


class RegisterProjectOneAuthor
{
    private AssessorModel $assessor;
    private AuthorModel $firstAuthor;
    private ProjectModel $project;

    public function __construct(array $params)
    {
        $this->assessor = new AssessorModel(array(
            'adviser_name' => $params['adviser_name'],
            'last_name' => $params['last_name'],
            'second_last_name' => $params['second_last_name'],
            'address' => $params['address'],
            'suburb' => $params['suburb'],
            'postal_code' => $params['postal_code'],
            'curp' => $params['curp'],
            'rfc' => $params['rfc'],
            'phone_contact' => $params['phone_contact'],
            'email' => $params['email'],
            'city' => $params['city'],
            'locality' => $params['locality'],
            'school_institute' => $params['school_institute'],
            'facebook' => $params['facebook'],
            'twitter' => $params['twitter'],
            'participation_description' => $params['participation_description']
        ));
        $this->firstAuthor = new AuthorModel(array(
            'author_id' => $params['author_id']
        ));
        $this->project = new ProjectModel(array(
            'project_id' => $params['project_id'],
            'project_name' => $params['project_name'],
            'project_description' => $params['project_description'],
            'id_sedes' => $params['id_sedes'],
            'id_category' => $params['id_category'],
            'url_video' => $params['url_video'],
            'id_area' => $params['id_area'],
            'id_modality' => $params['id_modality']
        ));
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql =
                "CALL SP_insert_project_m1 (
                    :id_categorias_in,
                    :id_modalidades_in,
                    :id_sedes_in,
                    :id_areas_in,
                    :nombre_in,
                    :descripcion_in,
                    :url_in,
                    @result,
                    :nombre_asesor_in,
                    :ape_pat_in,
                    :ape_mat_in,
                    :domicilio_in,
                    :colonia_in,
                    :cp_in,
                    :curp_in,
                    :rfc_in,
                    :telefono_in,
                    :email_in,
                    :municipio_in,
                    :localidad_in,
                    :escuela_in,
                    :facebook_in,
                    :twitter_in,
                    :descripcion_asesor_in,
                    :id_autores_in,
                    :id_proyectos_in
                )";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_categorias_in', $this->project->categoryId, \PDO::PARAM_INT);
            $stmt->bindParam(':id_modalidades_in', $this->project->modalityId, \PDO::PARAM_INT);
            $stmt->bindParam(':id_sedes_in', $this->project->campusId, \PDO::PARAM_INT);
            $stmt->bindParam(':id_areas_in', $this->project->areaId, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_in', $this->project->name, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_in', $this->project->description, \PDO::PARAM_STR);
            $stmt->bindParam(':url_in', $this->project->url, \PDO::PARAM_STR);
            $stmt->bindParam(':nombre_asesor_in', $this->assessor->name, \PDO::PARAM_STR);
            $stmt->bindParam(':ape_pat_in', $this->assessor->firstLastName, \PDO::PARAM_STR);
            $stmt->bindParam(':ape_mat_in', $this->assessor->secondLastName, \PDO::PARAM_STR);
            $stmt->bindParam(':domicilio_in', $this->assessor->address, \PDO::PARAM_STR);
            $stmt->bindParam(':colonia_in', $this->assessor->suburb, \PDO::PARAM_STR);
            $stmt->bindParam(':cp_in', $this->assessor->postalCode, \PDO::PARAM_STR);
            $stmt->bindParam(':curp_in', $this->assessor->curp, \PDO::PARAM_STR);
            $stmt->bindParam(':rfc_in', $this->assessor->rfc, \PDO::PARAM_STR);
            $stmt->bindParam(':telefono_in', $this->assessor->phone, \PDO::PARAM_STR);
            $stmt->bindParam(':email_in', $this->assessor->email, \PDO::PARAM_STR);
            $stmt->bindParam(':municipio_in', $this->assessor->city, \PDO::PARAM_STR);
            $stmt->bindParam(':localidad_in', $this->assessor->locality, \PDO::PARAM_STR);
            $stmt->bindParam(':escuela_in', $this->assessor->school, \PDO::PARAM_STR);
            $stmt->bindParam(':facebook_in', $this->assessor->facebook, \PDO::PARAM_STR);
            $stmt->bindParam(':twitter_in', $this->assessor->twitter, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_asesor_in', $this->assessor->description, \PDO::PARAM_STR);
            $stmt->bindParam(':id_autores_in', $this->firstAuthor->authorId, \PDO::PARAM_INT);
            $stmt->bindParam(':id_proyectos_in', $this->project->projectId, \PDO::PARAM_INT);

            $stmt->execute();

            return [
                'error'  => false,
                'status' => 200,
                'data' => array('message' => 'Se ha registrado el proyecto correctamente')
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
