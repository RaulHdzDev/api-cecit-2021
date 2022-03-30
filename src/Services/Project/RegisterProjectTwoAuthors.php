<?php

namespace App\Services\Project;

use App\App\Constants;
use App\App\Database;
use App\Models\AssessorModel;
use App\Models\AuthorModel;
use App\Models\ProjectModel;


class RegisterProjectTwoAuthors
{
    private AssessorModel $assessor;
    private AuthorModel $firstAuthor;
    private AuthorModel $secondAuthor;
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
        $this->secondAuthor = new AuthorModel(array(
            'name_author' => $params['second_author']['name_author'],
            'last_name' => $params['second_author']['last_name'],
            'second_last_name' => $params['second_author']['second_last_name'],
            'address' => $params['second_author']['address'],
            'suburb' => $params['second_author']['suburb'],
            'postal_code' => $params['second_author']['postal_code'],
            'curp' => $params['second_author']['curp'],
            'rfc' => $params['second_author']['rfc'],
            'phone_contact' => $params['second_author']['phone_contact'],
            'email' => $params['second_author']['email'],
            'city' => $params['second_author']['city'],
            'locality' => $params['second_author']['locality'],
            'school' => $params['second_author']['school'],
            'facebook' => $params['second_author']['facebook'],
            'twitter' => $params['second_author']['twitter'],
            'levelEnglish' => $params['second_author']['levelEnglish']
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
            "CALL SP_insert_project_m2 (
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
                    :nombre_autor,
                    :ape_pat_autor,
                    :ape_mat_autor,
                    :domicilio_autor,
                    :colonia_autor,
                    :cp_autor,
                    :curp_autor,
                    :rfc_autor,
                    :telefono_autor,
                    :email_autor,
                    :municipio_autor,
                    :localidad_autor,
                    :escuela_autor,
                    :facebook_autor,
                    :twitter_autor,
                    :nivel_ingles_autor,
                    :id_autores_in,
                    :id_proyectos_in
                )";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_categorias_in', $this->project->categoryId);
            $stmt->bindParam(':id_modalidades_in', $this->project->modalityId);
            $stmt->bindParam(':id_sedes_in', $this->project->campusId);
            $stmt->bindParam(':id_areas_in', $this->project->areaId);
            $stmt->bindParam(':nombre_in', $this->project->name);
            $stmt->bindParam(':descripcion_in', $this->project->description);
            $stmt->bindParam(':url_in', $this->project->url);
            $stmt->bindParam(':nombre_asesor_in', $this->assessor->name);
            $stmt->bindParam(':ape_pat_in', $this->assessor->firstLastName);
            $stmt->bindParam(':ape_mat_in', $this->assessor->secondLastName);
            $stmt->bindParam(':domicilio_in', $this->assessor->address);
            $stmt->bindParam(':colonia_in', $this->assessor->suburb);
            $stmt->bindParam(':cp_in', $this->assessor->postalCode);
            $stmt->bindParam(':curp_in', $this->assessor->curp);
            $stmt->bindParam(':rfc_in', $this->assessor->rfc);
            $stmt->bindParam(':telefono_in', $this->assessor->phone);
            $stmt->bindParam(':email_in', $this->assessor->email);
            $stmt->bindParam(':municipio_in', $this->assessor->city);
            $stmt->bindParam(':localidad_in', $this->assessor->locality);
            $stmt->bindParam(':escuela_in', $this->assessor->school);
            $stmt->bindParam(':facebook_in', $this->assessor->facebook);
            $stmt->bindParam(':twitter_in', $this->assessor->twitter);
            $stmt->bindParam(':descripcion_asesor_in', $this->assessor->description);
            $stmt->bindParam(':nombre_autor', $this->secondAuthor->name);
            $stmt->bindParam(':ape_pat_autor', $this->secondAuthor->firstLastName);
            $stmt->bindParam(':ape_mat_autor', $this->secondAuthor->secondLastName);
            $stmt->bindParam(':domicilio_autor', $this->secondAuthor->address);
            $stmt->bindParam(':colonia_autor', $this->secondAuthor->suburb);
            $stmt->bindParam(':cp_autor', $this->secondAuthor->postalCode);
            $stmt->bindParam(':curp_autor', $this->secondAuthor->curp);
            $stmt->bindParam(':rfc_autor', $this->secondAuthor->rfc);
            $stmt->bindParam(':telefono_autor', $this->secondAuthor->phone);
            $stmt->bindParam(':email_autor', $this->secondAuthor->email);
            $stmt->bindParam(':municipio_autor', $this->secondAuthor->city);
            $stmt->bindParam(':localidad_autor', $this->secondAuthor->locality);
            $stmt->bindParam(':escuela_autor', $this->secondAuthor->school);
            $stmt->bindParam(':facebook_autor', $this->secondAuthor->facebook);
            $stmt->bindParam(':twitter_autor', $this->secondAuthor->twitter);
            $stmt->bindParam(':nivel_ingles_autor', $this->secondAuthor->englishLevel);
            $stmt->bindParam(':id_autores_in', $this->firstAuthor->authorId);
            $stmt->bindParam(':id_proyectos_in', $this->project->projectId);

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
